<?php
/*
 * Plugin Name: Windsor - Catering
 * Description: Plugin para añadir una seccion de opciones en el panel de WordPress, para insertar las opciones de menu semanal y despues ser previsualizadas en diferentes campos Dropdown en plugin Gravity Forms.
 * Version: 1.0
 * Requires at least: 5.9
 * Requires PHP: 7.4
 * Author: Manuel Ramirez Coronel
 * Author URI: https://github.com/racmanuel
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: windsor-catering
 * Domain Path: /languages
 */

/** Include CMB2 in the plugin */
require __DIR__ . '/vendor/autoload.php';

class Windsor_Catering
{

    public function __construct()
    {
        /** Init propierties (in case you need it) */
    }

    public function i18()
    {
        load_plugin_textdomain('windsor-catering', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function init()
    {
        /** Add the Text Domain and Domain Path to change a lenguage in the plugin */
        add_action('init', array($this, 'i18'));
        /** Add CMB2 Fields and plugin page settings */
        add_action('cmb2_admin_init', array($this, 'windsor_catering_register_options_submenu_settings_menu'));


        /** Get the ID of the Gravity Form */
        $windsor_catering_options = get_option('windsor_catering_settings_options');
        $form_id = $windsor_catering_options['windsor_catering_gravity_form_id'];
        /**
         * Functions to Gravity Forms for pupulate with the Options of CMB2 the field Dropdown for more information
         * see https://docs.gravityforms.com/dynamically-populating-drop-down-or-radio-buttons-fields/
         */
        add_filter('gform_pre_render_'.$form_id, array($this, 'populate_posts'));
        add_filter('gform_pre_validation_'.$form_id, array($this, 'populate_posts'));
        add_filter('gform_pre_submission_filter_'.$form_id, array($this, 'populate_posts'));
        add_filter('gform_admin_pre_render_'.$form_id, array($this, 'populate_posts'));
    }

    /**
     * Hook in and register a menu options page.
     */
    public function windsor_catering_register_options_submenu_settings_menu()
    {
        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id' => 'windsor_catering_options_submenu_settings_menu',
            'title' => esc_html__('Catering', 'windsor-catering'),
            'object_types' => array('options-page'),

            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */

            'option_key' => 'windsor_catering_settings_options', // The option key and admin menu page slug.
            'icon_url' => 'dashicons-food', // Menu icon. Only applicable if 'parent_slug' is left empty
            'menu_title' => esc_html__('Catering', 'windsor-catering'), // Falls back to 'title' (above).
            'capability' => 'manage_options', // Cap required to view options-page.
            'save_button' => esc_html__('Guardar', 'windsor-catering'), // The text for the options-page save button. Defaults to 'Save'.
        ));

        /**
         * Custom Meta Boxes for settings plugin page
         */

        /*
         * Gravity Form ID
         */
        $cmb_options->add_field(array(
            'name' => __('Gravity Form', 'windsor-catering'),
            'desc' => __('Inserta el ID del formulario para mostrar .', 'windsor-catering'),
            'type' => 'title',
            'id' => 'gravity_form_title',
        ));
        $cmb_options->add_field(array(
            'name' => __('ID del Formulario', 'windsor-catering'),
            'desc' => __('Inserta el ID del formulario de Gravity Forms.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_gravity_form_id',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ));

        /*
         * Lunes
         */
        $cmb_options->add_field(array(
            'name' => __('Lunes', 'windsor-catering'),
            'desc' => __('Insertar las opciones de comida para los empleados.', 'windsor-catering'),
            'type' => 'title',
            'id' => 'lunes_title',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 1', 'windsor-catering'),
            'desc' => __('Inserta la opcion 1 de comida para el dia lunes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_lunes_1',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 2', 'windsor-catering'),
            'desc' => __('Inserta la opcion 2 de comida para el dia lunes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_lunes_2',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 3', 'windsor-catering'),
            'desc' => __('Inserta la opcion 3 de comida para el dia lunes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_lunes_3',
            'type' => 'text',
        ));

        /*
         * Martes
         */
        $cmb_options->add_field(array(
            'name' => __('Martes', 'windsor-catering'),
            'desc' => __('Insertar las opciones de comida para los empleados.', 'windsor-catering'),
            'type' => 'title',
            'id' => 'martes_title',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 1', 'windsor-catering'),
            'desc' => __('Inserta la opcion 1 de comida para el dia martes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_martes_1',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 2', 'windsor-catering'),
            'desc' => __('Inserta la opcion 2 de comida para el dia martes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_martes_2',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 3', 'windsor-catering'),
            'desc' => __('Inserta la opcion 3 de comida para el dia martes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_martes_3',
            'type' => 'text',
        ));

        /*
         * Miercoles
         */
        $cmb_options->add_field(array(
            'name' => __('Miercoles', 'windsor-catering'),
            'desc' => __('Insertar las opciones de comida para los empleados.', 'windsor-catering'),
            'type' => 'title',
            'id' => 'miercoles_title',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 1', 'windsor-catering'),
            'desc' => __('Inserta la opcion 1 de comida para el dia miercoles.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_miercoles_1',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 2', 'windsor-catering'),
            'desc' => __('Inserta la opcion 2 de comida para el dia miercoles.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_miercoles_2',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 3', 'windsor-catering'),
            'desc' => __('Inserta la opcion 3 de comida para el dia miercoles.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_miercoles_3',
            'type' => 'text',
        ));

        /*
         * Jueves
         */
        $cmb_options->add_field(array(
            'name' => __('Jueves', 'windsor-catering'),
            'desc' => __('Insertar las opciones de comida para los empleados.', 'windsor-catering'),
            'type' => 'title',
            'id' => 'jueves_title',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 1', 'windsor-catering'),
            'desc' => __('Inserta la opcion 1 de comida para el dia jueves.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_jueves_1',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 2', 'windsor-catering'),
            'desc' => __('Inserta la opcion 2 de comida para el dia jueves.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_jueves_2',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 3', 'windsor-catering'),
            'desc' => __('Inserta la opcion 3 de comida para el dia jueves.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_jueves_3',
            'type' => 'text',
        ));

        /** Viernes */
        $cmb_options->add_field(array(
            'name' => __('Viernes', 'windsor-catering'),
            'desc' => __('Insertar las opciones de comida para los empleados.', 'windsor-catering'),
            'type' => 'title',
            'id' => 'viernes_title',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 1', 'windsor-catering'),
            'desc' => __('Inserta la opcion 1 de comida para el dia viernes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_viernes_1',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 2', 'windsor-catering'),
            'desc' => __('Inserta la opcion 2 de comida para el dia viernes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_viernes_2',
            'type' => 'text',
        ));
        $cmb_options->add_field(array(
            'name' => __('Opcion 3', 'windsor-catering'),
            'desc' => __('Inserta la opcion 3 de comida para el dia viernes.', 'windsor-catering'),
            'default' => '',
            'id' => 'windsor_catering_viernes_3',
            'type' => 'text',
        ));
    }

    /** Function to use in Gravity Forms */
    public function populate_posts($form)
    {
        foreach ($form['fields'] as &$field) {
            /** This is the classes of CSS to put in field in Gravity Forms */
            $days = array('lunes', 'martes', 'miercoles', 'jueves', 'viernes');
            foreach ($days as $day) {
                if ($field->type != 'select' || strpos($field->cssClass, $day) === false) {
                    continue;
                }
                /** Get the options of Catering */
                $windsor_catering_options = get_option('windsor_catering_settings_options');
                $choices = array();
                $options = array('windsor_catering_' . $day . '_1', 'windsor_catering_' . $day . '_2', 'windsor_catering_' . $day . '_3');
                foreach ($options as $option) {
                    /** Save in the Array $choices the value of the option to print in Gravity Forms Field - Dropdown */
                    $choices[] = array('text' => $windsor_catering_options[$option], 'value' => $windsor_catering_options[$option]);
                }
                // update 'Select a Post' to whatever you'd like the instructive option to be
                $field->placeholder = __('Selecciona una Opcion','windsor-catering');
                $field->choices = $choices;

            }
        }
        return $form;
    }
}
$plugin = new Windsor_Catering();
$plugin->init();
