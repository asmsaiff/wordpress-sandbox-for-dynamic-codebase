<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <?php
                            $terms = get_terms( array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                            ) );

                            foreach ($terms as $term) {
                                // echo '<button data-filter=".' . $term->slug . '">' . $term->name . '</button>';

                                echo '<button class="nav-link" id="v-pills-' . $term->slug . '-tab" data-bs-toggle="pill" data-bs-target="#v-pills-' . $term->slug . '" type="button" role="tab" aria-controls="v-pills-' . $term->slug . '" aria-selected="true">' . $term->name . '</button>';
                            }
                        ?>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <?php
                            $tax = 'product_cat';
                            $expand_args = array(
                                'taxonomy' => $tax,
                            );
                            $expand_category = get_categories($expand_args);
                            $c = 1;
    
                            foreach($expand_category as $ekey => $expcat) :
                        ?>
                        <div class="tab-pane fade" id="v-pills-<?php echo $expcat->slug; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $expcat->slug; ?>-tab" tabindex="0">
                            <?php
                                $category_post = new WP_Query(array(
                                    'post_type'         => 'products',
                                    'posts_per_page'    => -1,
                                    'order'				=>	'ASC',
                                    'orderby'           => 'date',
                                    'tax_query'         => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'slug',
                                            'terms'    => $expcat->slug,
                                        ),
                                    ),
                                ));

                                while($category_post->have_posts()) :
                                    $category_post->the_post();

                                    the_title();

                                endwhile;
                            ?>
                        </div>
                        <?php
                            endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>