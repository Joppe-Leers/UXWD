<?php


class Menu_model
{
    private $menu_items;

    /**
     * Menu_model constructor
     */
    public function __construct()
    {
        $this->menu_items = array(
            array('iconName'=>'home', 'link'=>'hub', 'className'=>'inactive','id'=>'icon'),
            array('iconName'=>'people_alt', 'link'=>'groups', 'className'=>'inactive','id'=>'icon'),
            array('iconName'=>'add_a_photo', 'link'=>'addObservation', 'className'=>' active', 'id'=>'add_icon'),
            array('iconName'=>'leaderboard', 'link'=>'leaderboardSelect', 'className'=>'inactive','id'=>'icon'),
            array('iconName'=>'person', 'link'=>'profile', 'className'=>'inactive','id'=>'icon')
        );
    }

    private function set_active($menuLink){
        foreach ($this->menu_items as &$item) {
            if(strcasecmp($menuLink, $item['link']) == 0) {
                $item['className'] = 'active';
            }
            else {
                $item['className'] = 'inactive';
            }
        }
    }

    public function get_menuitems($menuLink){
        $this->set_active($menuLink);

        return $this->menu_items;
    }
}