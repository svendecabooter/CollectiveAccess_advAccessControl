<?php
/* ----------------------------------------------------------------------
 * plugins/advAccessController/controllers/AccessController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 */

   require_once(__CA_LIB_DIR__.'/core/Configuration.php');

   class AccessController extends ActionController {
     # -------------------------------------------------------
     protected $opo_config;    // plugin configuration file
     # -------------------------------------------------------
     #
     # -------------------------------------------------------
     public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
       parent::__construct($po_request, $po_response, $pa_view_paths);
     }
     # -------------------------------------------------------
     public function Denied() {
      $url = $this->request->getParameter('url', pString);
      $url = urldecode($url);
      $summary_url = str_replace("/Edit/", "/Summary/", $url);
      $this->view->setVar('redirect_url', $summary_url);
       $this->render('access_denied_html.php');
     }
     # -------------------------------------------------------
   }
 ?>