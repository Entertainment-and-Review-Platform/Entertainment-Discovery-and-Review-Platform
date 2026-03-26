<?php get_header(); ?>

<main style="padding: 40px; max-width: 900px; margin: 0 auto;">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <h1><?php the_title(); ?></h1>

        <div style="margin-bottom: 20px;">
            <?php the_content(); ?>
        </div>

        <hr style="margin: 30px 0;">

        <h2>Quiz Question</h2>

        <p><strong><?php the_field('question_1'); ?></strong></p>

        <form id="quiz-form" style="margin-top: 20px;">
            <p><label><input type="radio" name="quiz_answer" value="a"> <?php the_field('option_a'); ?></label></p>
            <p><label><input type="radio" name="quiz_answer" value="b"> <?php the_field('option_b'); ?></label></p>
            <p><label><input type="radio" name="quiz_answer" value="c"> <?php the_field('option_c'); ?></label></p>
            <p><label><input type="radio" name="quiz_answer" value="d"> <?php the_field('option_d'); ?></label></p>

            <button type="button" id="show-result-btn" style="margin-top: 20px; padding: 10px 20px; cursor: pointer; background-color: #ADD8E6; color: white; transition: text-shadow 0.3s;" onmouseover="this.style.textShadow='0 0 10px black'" onmouseout="this.style.textShadow='none'">
                See My Result
            </button>
        </form>

        <div id="quiz-result" style="display: none; margin-top: 40px;">
            <hr style="margin: 30px 0;">

            <h2>Quiz Result</h2>
            <p><?php the_field('result_text'); ?></p>

            <?php
            $associated_show = get_field('associated_showmovie');
            if ( $associated_show ) :
            ?>
                <p>
                    <strong>Recommended Show / Movie:</strong>
                    <a href="<?php echo esc_url( get_permalink( $associated_show->ID ) ); ?>">
                        <?php echo esc_html( get_the_title( $associated_show->ID ) ); ?>
                    </a>
                </p>
            <?php endif; ?>

            <p><strong>Quiz Category:</strong> <?php the_field('quiz_category'); ?></p>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const button = document.getElementById('show-result-btn');
                const resultBox = document.getElementById('quiz-result');
                const answers = document.querySelectorAll('input[name="quiz_answer"]');

                button.addEventListener('click', function () {
                    let selected = false;

                    answers.forEach(function(answer) {
                        if (answer.checked) {
                            selected = true;
                        }
                    });

                    if (!selected) {
                        alert('Please select an answer before viewing your result.');
                        return;
                    }

                    resultBox.style.display = 'block';
                    resultBox.scrollIntoView({ behavior: 'smooth' });
                });
            });
        </script>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>