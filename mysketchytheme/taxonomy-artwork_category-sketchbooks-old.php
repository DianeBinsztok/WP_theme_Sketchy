<?php
// TEMPLATE ARTWORK CATEGORY - SKETCHBOOKS
get_header();

// I - LES ARGUMENTS DE LA QUERY, EN FONCTION DE PARAMÈTRES D'URL
// La requête
$args = array(
    'post_type' => 'artwork',
    'tax_query' => array(
        array(
            'taxonomy' => 'artwork_category',
            'field'    => 'slug',
            'terms'    => 'Sketchbooks',
        ),
    ),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    /* Requête des artworks, dans l'ordre de leur année de réalisation */
    'meta_key' => 'artwork_year', // Clé du champ personnalisé pour l'année
    'orderby' => 'meta_value_num', // Ordonner par la valeur numérique du champ
    'order' => 'DESC', // Du plus récent au plus ancien
);

// II - LA QUERY
$artworks_query = new WP_Query($args);

// III - LE TEMPLATE
// Parcourir les résultats
if ($artworks_query->have_posts()) {
    // Récupérer les propriétés de chaque artwork
    $artworks = [];
    // Pour l'ordre d'affichage des images
    $indexInLoop = 0;
    while ($artworks_query->have_posts()) {
        $artworks_query->the_post();
        $post = get_post();
        $artwork = [
            "id" => $post->ID,
            "indexInLoop" => $indexInLoop,
            "title" => $post->post_title,
            "image_large" => get_the_post_thumbnail_url($post->ID, 'large'), // Image pour le slider
            "image_thumb" => get_the_post_thumbnail_url($post->ID, 'medium_large'), // Image pour la galerie
            "year" => get_post_meta($post->ID, "artwork_year", true),
            "slug" => $post->post_name,
            "excerpt" => $post->post_excerpt,
            "techniques" => get_post_meta($post->ID, "artwork_techniques", true),
            "tags" => get_the_tags(),
            "categories" => get_the_terms($post, "artwork_category"),
            "related_post_id" => get_post_meta($post->ID, "artwork_related_post_id", true)
        ];
        array_push($artworks, $artwork);
        $indexInLoop++;
    }
    // Affichage en deux parties : les images et les popups. Chaque image est cliquable et déclenche une popup qui affichera des propriétés en plus : le titre, l'année, les techniques, etc.

    // Pour chaque date, n'afficher qu'une image (la première rencontrée)
    $seen_years = [];
    $artworks_filtered_one_by_year = [];
    foreach ($artworks as $artwork) {
        if (!in_array($artwork['year'], $seen_years)) {
            $seen_years[] = $artwork['year'];
            $artworks_filtered_one_by_year[] = $artwork;
        }
    }
}

?>

<!-- SECTION : GALERIE D'ARTWORKS CLIQUABLES -->
<section class='with-padding' id='gallery_clickable-artworks'>
    <?php foreach ($artworks_filtered_one_by_year as $artwork) { ?>
        <div class='clickable-artwork' id="<?php echo esc_html($artwork['indexInLoop']) ?>">
            
            <img src="<?php echo esc_url($artwork['image_thumb'])?>" alt=""/>
            
            <div class='artwork_overlay'>
                <h2><?php echo esc_html($artwork['year'])?></h2>
            </div>
            
        </div>
    <?php } ?>
</section>

<!-- SECTION : POPUP_OVERLAY POUR CHAQUE ARTWORK -->
<section id='slider-container' class='hide'>
    <button class="slider__close-button" aria-label="Fermer">&times;</button>
    <div class="slider-content-wrapper">
        <div class="slider">

            <!-- Les slides ne contiennent que les images (les infos seront fixes dans la pages, mises à jour par le script côté front)-->
            <!-- LES IMAGES -->
            <div class="slider__slides">
                <!-- Pour chaque artwork, ajouter ses infos dans les datasets. Elles pourront ensuite être récupérées par le script côté front-->
                <?php foreach ($artworks as $index => $artwork): ?>
                    <div class="slider__slide" 
                        data-index="<?= $index ?>"
                        data-category="<?= esc_attr(json_encode(array_map(function($cat) { if($cat){return $cat->name; } }, (array)$artwork['categories']))) ?>"
                        data-title="<?= esc_attr($artwork['title']) ?>"
                        data-year="<?= esc_attr($artwork['year']) ?>"
                        data-excerpt="<?= esc_attr($artwork['excerpt']) ?>"
                        data-techniques='<?= esc_attr(json_encode($artwork['techniques'])) ?>'
                        data-nb-of-artworks-of-the-same-year="<?= count(array_filter($artworks, function($a) use ($artwork) { return $a['year'] === $artwork['year']; })) ?>"
                    >
                        <!-- Gestion des tags -->
                        <img src="<?= esc_url($artwork['image_large']) ?>" alt="<?= esc_attr($artwork['title']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- LES INFOS -->
            <!-- Pas de PHP ici : les infos seront récupérées dans les datasets et mises à jour par le script JS-->
            <div class="slider__info">
                <h2 class="slider__title"></h2>
                <p class="slider__excerpt"></p>

                <div class="slider__meta">
                    <p class="slider__year"></p>
                    <ul class="slider__techniques"></ul>
                </div>

            </div>
        </div>

        <div class="slider__nav">
            <button class="slider__nav-button slider__nav-button--prev" aria-label="Précédent">&lt;</button>
            <button class="slider__nav-button slider__nav-button--next" aria-label="Suivant">&gt;</button>
        </div>

        <div class="slider__dots">
                    <!-- Ici, l'affichage des points de navigation sera géré par le script JS -->
        </div>
    </div>
</section> 
<?php
    get_footer();
?>