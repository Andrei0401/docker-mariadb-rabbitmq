<?php

namespace App\Http\Models;

/**
 * Description of UrlsMariaDBModel
 *
 * @author user
 */
class UrlsMariaDBModel extends MariaDBModel {

    public function insertRow($url, $contentLength) {
        $this->query('INSERT INTO urls (`url`, `content_length`, `timestamp`) VALUES (:url, :length, :time);', array('url' => $url, 'length' => $contentLength, 'time' => (new \DateTime())->format('Y-m-d H:i:s')));
    }

    public function getRows() {
        $results = $this->query('SELECT COUNT(*) as count, MINUTE(timestamp) as minute, AVG(content_length) as avg_content_length, MIN(timestamp) as min, MAX(timestamp) as max FROM urls GROUP BY MINUTE(timestamp)');
        return $results;
    }
}
