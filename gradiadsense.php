<?php
/**
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement.
*
* You must not modify, adapt or create derivative works of this source code
*
* @author AngelDavidBermeo
* @license LICENSE.txt
*/

Class GradiAdsense extends Module {

    /**
     * Nombres de los campos de la publicidad en la BBDD 
     */
    
    public $array_fields = [
        'GRADI_ADSENSE_BACK_BANNER', 'GRADI_ADSENSE_AD_TITLE', 'GRADI_ADSENSE_AD_DESCRIPTION',
        'GRADI_ADSENSE_CTA_LABEL','GRADI_ADSENSE_CTA_URL', 'GRADI_ADSENSE_SWITCH_STATUS'
    ];

    /**
     * Metodo Constructor
     */

    public function __construct(){
        $this->name = 'GradiAdsense';
        $this->version = '1.0';
        $this->author = 'AngelDavidBermeo';
        $this->displayName = $this->l('Gradi Adsense');
        $this->description = $this->l('Añade increibles banners publicitarios a tu tienda online. Puedes personalizar la información y contenido de tu anuncio con ayuda de nuestras opciones de configuración, es tan simple como instalarlo y empezar a crear!');
        $this->controllers = array('default');
        $this->bootstrap = 1;

        parent::__construct();
    }

    /**
     * Metodo de instalación del modulo
     */

    public function install(){

        if( !parent::install() || 
            !$this->registerHook('displayHome') ||
            !$this->registerHook('displayHeader') ||
            !$this->installModule()
        )
            return false;
        return true;
    }
    
    /**
     * Metodo de desisntalación del modulo
     */
    
    public function uninstall(){
            
        if( !parent::uninstall() || 
            !$this->unregisterHook('displayHome') ||
            !$this->unregisterHook('displayHeader') ||
            !$this->unistallModule()
        )
            return false;
        return true;
    }

    /**
     * Lista de valores por defecto para la publicidad despues de instalar el 
     * modulo
     */

    public function installModule(){

        $back_banner = 'xbox-control.png';
        $ad_title = '!Videojuegos en promocion!';
        $ad_description = 'Compra YA tus videojuegos favoritos en promocion solo por pocos dias...';
        $cta_label = 'Comprar Ahora';
        $cta_url = 'https://www.alkosto.com/videojuegos';
        $switch_status = 1; 

        Configuration::updateValue('GRADI_ADSENSE_BACK_BANNER', $back_banner);
        Configuration::updateValue('GRADI_ADSENSE_AD_TITLE', $ad_title);
        Configuration::updateValue('GRADI_ADSENSE_AD_DESCRIPTION', $ad_description);
        Configuration::updateValue('GRADI_ADSENSE_CTA_LABEL', $cta_label);
        Configuration::updateValue('GRADI_ADSENSE_CTA_URL', $cta_url);
        Configuration::updateValue('GRADI_ADSENSE_SWITCH_STATUS', $switch_status);

        return true;
    }

    /**
     * Metodo encargado de la eliminación de los valores 
     * y campos existente en la BBDD
     */

    public function unistallModule(){

        for($i =0; $i<count($this->array_fields); $i++){
            Configuration::deleteByName($this->array_fields[$i]);
        }

        return true;
        
    }

    /**
     * Metodo para obtener el contenido de los campos de la BBDD
     */
    
    public function getContent(){

        return $this->postProcess() . $this->getForm();
    }

    /**
     * Obtiene y crea los campos del formulario para la creación de la publicidad
     */
    
    public function getForm(){

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->languages = $this->context->controller->getLanguages();
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $this->context->controller->default_form_language;
        $helper->allow_employee_form_lang = $this->context->controller->allow_employee_form_lang;
        $helper->title = $this->displayName;



        $helper->fields_value['back_banner'] = Configuration::get('GRADI_ADSENSE_BACK_BANNER');
        $helper->fields_value['ad_title'] = Configuration::get('GRADI_ADSENSE_AD_TITLE');
        $helper->fields_value['ad_description'] = Configuration::get('GRADI_ADSENSE_AD_DESCRIPTION');
        $helper->fields_value['cta_label'] = Configuration::get('GRADI_ADSENSE_CTA_LABEL');
        $helper->fields_value['cta_url'] = Configuration::get('GRADI_ADSENSE_CTA_URL');
        $helper->fields_value['switch_status'] = Configuration::get('GRADI_ADSENSE_SWITCH_STATUS');


        $helper->submit_action = 'gradiadsense';
      

        $this->form[0] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->displayName
                 ),
                'input' => array(
                    array(
                        'type' => 'file',
                        'label' => $this->l('Banner Background Image'),
                        'desc' => $this->l('Imagenes Sugeridas: /gradiadsense/img. Si no adjunta una imagen el sistema cargara una por defecto'),
                        'hint' => $this->l('Banner Background'),
                        'name' => 'back_banner',
                        'lang' => false,
                        'required' => false,
                    ), array(
                        'type' => 'text',
                        'label' => $this->l('Ad Title'),
                        'desc' => $this->l('Banner Ad tittle'),
                        'hint' => $this->l('Ad Ttitle'),
                        'name' => 'ad_title',
                        'lang' => false,
                     ), array(
                        'type' => 'text',
                        'label' => $this->l('Ad Description'),
                        'desc' => $this->l('Banner Ad Description'),
                        'hint' => $this->l('Banner Description'),
                        'name' => 'ad_description',
                        'lang' => false,
                     ), array(
                        'type' => 'text',
                        'label' => $this->l('CTA Label'),
                        'desc' => $this->l('CTA Label Description'),
                        'hint' => $this->l('CTA Label'),
                        'name' => 'cta_label',
                        'lang' => false,
                     ), array(
                        'type' => 'text',
                        'label' => $this->l('CTA Url'),
                        'desc' => $this->l('CTA Url Description'),
                        'hint' => $this->l('CTA Url'),
                        'name' => 'cta_url',
                        'lang' => false,
                     ), array(
                        'type' => 'switch',
                        'label' => $this->l('Switch Enabled/Disabled Ad'),
                        'desc' => $this->l('Ad Custom Switch'),
                        'hint' => $this->l('Custom Switch'),
                        'name' => 'switch_status',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                        'lang' => false,
                     ),
                 ),
                'submit' => array(
                    'title' => $this->l('Save')
                 )
             )
         );
        
        return $helper->generateForm($this->form);
         
    }
    
    /**
     * Metodo que se ejecuta al enviar los valores de nuestro formulario de configuración
     */

    public function postProcess(){

        if(Tools::isSubmit('gradiadsense')) {
            $back_banner = Tools::getValue('back_banner');
            $ad_title = Tools::getValue('ad_title');
            $ad_description = Tools::getValue('ad_description');
            $cta_label = Tools::getValue('cta_label');
            $cta_url = Tools::getValue('cta_url');
            $switch_status = Tools::getValue('switch_status');

            Configuration::updateValue('GRADI_ADSENSE_BACK_BANNER', $back_banner);
            Configuration::updateValue('GRADI_ADSENSE_AD_TITLE', $ad_title);
            Configuration::updateValue('GRADI_ADSENSE_AD_DESCRIPTION', $ad_description);
            Configuration::updateValue('GRADI_ADSENSE_CTA_LABEL', $cta_label);
            Configuration::updateValue('GRADI_ADSENSE_CTA_URL', $cta_url);
            Configuration::updateValue('GRADI_ADSENSE_SWITCH_STATUS', $switch_status);


            return $this->displayConfirmation($this->l('Actualizado Correctamente'));
        }
    }

    /**
     * Metodo base para las acciones del hookDisplayHome
     */
    
    public function hookDisplayHome(){

        $back_banner = Configuration::get('GRADI_ADSENSE_BACK_BANNER');
        $ad_title = Configuration::get('GRADI_ADSENSE_AD_TITLE');
        $ad_description = Configuration::get('GRADI_ADSENSE_AD_DESCRIPTION');
        $cta_label = Configuration::get('GRADI_ADSENSE_CTA_LABEL');
        $cta_url = Configuration::get('GRADI_ADSENSE_CTA_URL');
        $switch_status = Configuration::get('GRADI_ADSENSE_SWITCH_STATUS');

        if($switch_status){
            $this->context->smarty->assign(array(
                'ad_image' => $back_banner,
                'ad_title' => $ad_title,
                'ad_description' => $ad_description,
                'cta_label' => $cta_label,
                'cta_url' => $cta_url,
                'switch_status' => $switch_status,
            ));
        }else{
            $switch_status = 0;
            $this->context->smarty->assign(array(
                'switch_status' => $switch_status,
            ));
        }
        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/home.tpl');
    }

    /**
     * Metodo base para las acciones del hookDisplayHome
     */

    public function hookDisplayHeader(){

        if(isset($this->context->controller->php_self) && $this->context->controller->php_self == 'index'){
            $this->context->controller->addCSS($this->local_path.'views/css/styles.css');
        }
    }
 
}