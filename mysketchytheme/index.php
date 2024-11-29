<?php
/*
 * Template Name: Sketchy
 */

get_header();

//the_content();
?>

<h1 style="text-align:center;">Bienvenue sur mon sketchbook</h1>
<section>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore enim, quaerat illo repellat dignissimos
        laudantium corporis nisi quos iure maiores rem ratione labore ad voluptatem? Eos cupiditate voluptatum sint
        qui.</p>
</section>
<section style="display:flex; max-width:100%;">
    <div style="margin:0 1rem;">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=nu">
            <div style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/47.jpg'); 
                background-size: cover;
                background-repeat: no-repeat;
                width:100%; height:600px;">
                <h2>Des gens tous nus</h2>
                <p>Je paie des sous pour aller dans des ateliers privés voir des gens tous nus.</p>
            </div>
        </a>
    </div>

    <div style="margin:0 1rem;">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=croquis">
            <div style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/56.jpg'); 
                background-size: cover;
                background-repeat: no-repeat;
                width:100%; height:600px;">
                <h2>Des croquis</h2>
                <p>Quand je m'ennuie, je croque des trucs... Je m'ennuie souvent et partout.</p>
            </div>
        </a>
    </div>
    <div style="margin:0 1rem;">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=peinture">
            <div style="
                background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/116-scaled.jpg'); 
                background-size: cover;
                background-repeat: no-repeat;
                width:100%; height:600px;">
                <h2>De l'huile</h2>
                <p>Mes rares tentatives.</p>
            </div>
        </a>
    </div>
</section>
<section>
    <h2>À propos</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni adipisci soluta, explicabo dolorem voluptates
        earum alias in dicta ea ullam est, consectetur repellat nobis eos mollitia expedita praesentium! Quibusdam,
        necessitatibus.</p>
</section>

<?php
get_footer();

