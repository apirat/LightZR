<?php
echo str_replace(array('{AWSTAG}','{HTTP}','{QUERY}'),array(lz::$c['awstag'],HTTP,QUERY),$box['option']);
?>