<?php

namespace WPC;

class Widget_Loader
{
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function nesar_widgets_style()
    {
        wp_register_style('nesar_widgets', (__DIR__ . '/decor.css'));
        wp_enqueue_style('nesar_widgets');
    }

    public function pushWidgets()
    {

        $Widgets = [
            "ChildPostArchive",
            "List_Paragraph",
            "Service",
            "TallyfyTestimonial",
            "Tabs",
            "HeadingWithIcon",
            "MultiButtons",
            "PricingTable",
            "TallyfyPostListByType",
            "TestimonialCard",
        ];

        foreach ($Widgets as $class) {
            $name = 'WPC\Widgets\\' . $class;

            require_once(__DIR__ . '/widgets/' . $class . '.php');
            \Elementor\Plugin::instance()->widgets_manager->register(new $name);
        }
    }



    public function __construct()
    {
        add_action('elementor/widgets/register', [$this, 'pushWidgets'], 99);
    }
}

// Instantiate Plugin Class
Widget_Loader::instance();
