<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'custom/vendor/simplepie/SimplePie.compiled.php';

class RSSApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetItemEndpoint' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array('RSS', 'GetItems'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'GetItems',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Get today\'s matches live scores',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }
 
    public function GetItems($api, $args)
    {
        $rss = new SimplePie();
        $rss->set_cache_location('cache/rss/');
        $rss->set_cache_duration(1800);
        $rss->set_feed_url($args['website']);
        $rss->init();

        foreach ($rss->get_items(0,$args['limit']) as $item) {
            $feed['responseData']['results'][]= array(
                "title"=>$item->get_title().PHP_EOL,
                "date"=>$item->get_date().PHP_EOL,
                "link"=>$item->get_link().PHP_EOL,
                "content"=>$item->get_description().PHP_EOL,
                );
                
        }
        $GLOBALS['log']->fatal(print_r($feed,true));
        return $feed;//json_encode($feed);
    }
}
 
?>