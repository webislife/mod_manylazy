<?php
defined('_JEXEC') or die('Restricted access');
/**
 * Lazy load ддя продуктов virtemart 2 и joomla 2.5.x.
 * by webislife.ru
 */
class ModManyLazyHelper{

   public static function getProdsRand($col)
   {
        $sql_query = "SELECT catru.category_name, cat.virtuemart_category_id, pru.virtuemart_product_id, pru.product_name, pm.file_url, pri.product_price 
                    FROM #__virtuemart_product_categories AS cat
                    INNER JOIN #__virtuemart_categories_ru_ru AS catru ON (catru.virtuemart_category_id = cat.virtuemart_category_id)
                    INNER JOIN #__virtuemart_products_ru_ru AS pru ON (pru.virtuemart_product_id = cat.virtuemart_product_id)
                    INNER JOIN #__virtuemart_product_medias AS med ON (med.virtuemart_product_id = cat.virtuemart_product_id)
                    INNER JOIN #__virtuemart_medias AS pm ON (pm.virtuemart_media_id = med.virtuemart_media_id)
                    INNER JOIN #__virtuemart_product_prices AS pri ON (pri.virtuemart_product_id = cat.virtuemart_product_id)
                    ORDER BY RAND()";
        $db = JFactory::getDbo();
        $db->setQuery($sql_query,0,$col);

        $prods = array();
        foreach ($db->loadObjectlist() as $key => $p)
        {    
            $product = array();
            $product['name'] = $p->product_name;
            $product['cat_name'] = $p->category_name;
            $product['cat_url'] = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$p->virtuemart_category_id);
            $product['product_url'] = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$p->virtuemart_product_id.'&virtuemart_category_id='.$p->virtuemart_category_id);        
            $product['price'] = round($p->product_price);
            $product['image_url'] = $p->file_url;
            $prods[$key] = $product;
        }
        return $prods;
   }
   public static function getJsonProds($col)
   {
    return json_encode(self::getProdsRand($col));
   }
}
?>