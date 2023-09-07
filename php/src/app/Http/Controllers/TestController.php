<?php
namespace App\Http\Controllers;

use App\Helper\Url;
use App\Rabbitmq\Client;
use App\Http\Models\UrlsMariaDBModel;

class TestController extends Controller {

    public function index()
    {
        $countUrls = $_REQUEST['n'] ?? 10;

        $urls = Url::generateUrls($countUrls);

        foreach ($urls as $url) {
           Client::publishMessage($url);
           //sleep(mt_rand(5, 30));
        }

        $receivedUrls = array();

        do {
            $url = Client::receiveMessage();
            if ($url) {
                $receivedUrls[] = $url;
            }
        } while ($url);

        $data = array();

        foreach ($receivedUrls as $url) {
            $data[] = array(
                'url'               => $url,
                'content_length'    => strlen($url),
            );
        }

        $modelMariaDb = new UrlsMariaDBModel();

        $modelMariaDb->setTransaction();
        foreach ($data as $d) {
            $modelMariaDb->insertRow($d['url'], $d['content_length']);
        }
        $modelMariaDb->commitTransaction();

        $mariaDBData = $modelMariaDb->getRows();

        return $this->view('test', array(
            'mariaDbData' => $mariaDBData,
        ));
    }
}
