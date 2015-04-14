<?php
add_filter( 'the_content', 'images_ssl' );
function images_ssl($content){
    if ($_SERVER["SERVER_PORT"] == "443"){
        $doc = new DOMDocument();
        @$doc->loadHTML($content);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
            if (strpos($tag->getAttribute('src'), 'http://') !== false){
                $content = str_replace($tag->getAttribute('src'), str_replace('http:','', $tag->getAttribute('src')), $content);
            }
        }
    }
    $content = str_replace('H2Only','H<sub>2</sub>Only', $content);
    return $content;
}

add_filter( 'the_title', 'h2only_title' );
function h2only_title($title) {
    $title = str_replace('H2Only','H<sub>2</sub>Only', $title);
    return $title;
}    
?>