<?php
require "scraper.php";

function download_img($src, $name) {
    preg_match('/\.[a-z]+$/', $src, $matches);
    $ext = $matches[0];

    $name = preg_replace('/\W+/', '_', $name);
    $name = trim($name, "_");

    copy($src, $name . $ext);
}

function scrape_genre(string $link, int $max_num) {
    $scraper = new Scraper($link);
    $book_names = $scraper->getTextContents($scraper->query('//ol[@class="row"]//li/article/h3/a'));
    $images_src = $scraper->getTextContents($scraper->query('//ol[@class="row"]//li/article/div[@class="image_container"]/a/img/@src'));

    $counter = 0;
    foreach ($book_names as $key => $book_name) {
        if ($counter >= $max_num) {
            return;
        }
        // echo $book_name . " : " . $images_src[$key] . "<br>" . "\n";
        $img_link = $link;
        $img_link = preg_replace('/\/[^\/]*$/', '/' . $images_src[$key], $img_link);
        echo $book_name . " : " . $img_link . "<br>" . "\n";
        download_img($img_link, $book_name);
        $counter++;
    }

    $next_page_node = $scraper->query('//li[@class="next"]/a/@href');
    if (count($next_page_node) !== 0) {
        $next_page = $scraper->getTextContents($next_page_node)[0];
        $next_page_link = preg_replace('/\/[^\/]*$/', '/' . $next_page, $link);
        scrape_genre($next_page_link, $max_num - $counter);
    }
}

const URL = 'https://books.toscrape.com/';

$scraper = new Scraper(URL);

$genre_nodes = $scraper->query('//div[@class="side_categories"]//ul//li//ul//li/a');
$genre_names = $scraper->getTextContents($genre_nodes);

$genre_hrefs =  $scraper->query('//div[@class="side_categories"]//ul//li//ul//li/a/@href');
$genre_links = $scraper->getTextContents($genre_hrefs);

if (!mkdir("books")) {
    echo "Dir 'books' creation failed.";
    die(1);
}
if (!chdir("books")) {
    echo "Can't change cwd to dir 'books'.";
    die(1);
}

echo "<br>" . "\n";
foreach ($genre_names as $key => $genre_name) {
    echo "SCRAPING $genre_name... " . "<br>" . "\n";;
    if (!mkdir($genre_name)) {
        echo "ERR: Dir '$genre_name' creation failed." . "<br>\n";
        die(1);
    }
    if (!chdir($genre_name)) {
        echo "ERR: Can't change cwd to dir '$genre_name'." . "<br>\n";
        die(1);
    }
    scrape_genre(URL . $genre_links[$key], 1);
    if (!chdir('..')) {
        echo "ERR: Can't change cwd to dir '..'." . "<br>\n";
        die(1);
    }
    echo "DONE" . "<br>\n";
}