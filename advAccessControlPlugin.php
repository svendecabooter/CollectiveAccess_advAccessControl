<?php
/* ----------------------------------------------------------------------
 * advAccessControlPlugin.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 */

	class advAccessControlPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		private $opo_config;
		private $ops_plugin_path;
    private $opo_notification_manager;
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->ops_plugin_path = $ps_plugin_path;
			$this->description = _t('Provides advanced access control features.');
			parent::__construct();
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/advAccessControl.conf');
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return true - the advAccessControlPlugin plugin always initializes ok
		 */
		public function checkStatus() {
			return array(
				'description' => $this->getDescription(),
				'errors' => array(),
				'warnings' => array(),
				'available' => ((bool)$this->opo_config->get('enabled'))
			);
		}
		# -------------------------------------------------------
		/**
		 * Implements hookEditItem - react on edit pages of items
		 */
		public function hookEditItem(&$pa_params) {
			$t_subject = $pa_params['instance'];	// get instance from params
      $vn_id = $t_subject->getPrimaryKey();
      $table_name = $pa_params['table_name'];
      $access = TRUE;
      $o_req = $this->getRequest();

      // Check if user has access to edit this item
      if ($vn_id) { // Only check on existing objects
        // Check if we can fetch the user, and if the user is allowed to bypass this check
        if (isset($o_req->user) && !$o_req->user->canDoAction('can_edit_all')) {
          // Check if user can edit all items of this type, or only his own
          if (!$o_req->user->canDoAction('can_edit_all_' . $table_name)) {
            // This user is not allowed to edit all items. Check if he has edit access to this particular object.
            $creation_info = $t_subject->getCreationTimestamp();
            $creator_uid = $creation_info['user_id'];
            $current_uid = $o_req->user->getPrimaryKey();
            if ($creator_uid != $current_uid) {
              $access = FALSE;
            }
          }
        }

        if (!$access) {
          if (($o_app = AppController::getInstance()) && ($o_resp = $o_app->getResponse())) {
            $fullurl = $this->getRequest()->getFullUrlPath();
            $o_resp->setRedirect(caNavUrl($o_req, "advAccessControl", "Access", "Denied") . '?url='. urlencode($fullurl));
          }
        }
      }

    }
		# -------------------------------------------------------
		/**
		 * Get plugin user actions
		 */
		public function hookGetRoleActionList($pa_role_list) {
      $pa_role_list['plugin_advAccessControl'] = array(
        'label' => _t('Advanced access control'),
        'description' => _t('Actions for the advanced access control plugin'),
        'actions' => advAccessControlPlugin::getRoleActionList(),
      );
      return $pa_role_list;
		}
    # -------------------------------------------------------
    static public function getRoleActionList() {
			return array(
				'can_edit_all' => array(
					'label' => _t('Edit all content'),
					'description' => _t('Can edit all content, not just own content.')
				),
        'can_edit_all_ca_objects' => array(
          'label' => _t('Edit all objects'),
          'description' => _t('Can edit all objects, not just own objects.'),
        ),
        'can_edit_all_ca_entities' => array(
          'label' => _t('Edit all entities'),
          'description' => _t('Can edit all entities, not just own entities.'),
        ),
        'can_edit_all_ca_object_representations' => array(
          'label' => _t('Edit all object representations'),
          'description' => _t('Can edit all object representations, not just own object representations.'),
        ),
        'can_edit_all_ca_object_lots' => array(
          'label' => _t('Edit all object lots'),
          'description' => _t('Can edit all object lots, not just own object lots.'),
        ),
        'can_edit_all_ca_places' => array(
          'label' => _t('Edit all places'),
          'description' => _t('Can edit all places, not just own places.'),
        ),
        'can_edit_all_ca_occurrences' => array(
          'label' => _t('Edit all occurrences'),
          'description' => _t('Can edit all occurrences, not just own occurrences.'),
        ),
        'can_edit_all_ca_collections' => array(
          'label' => _t('Edit all collections'),
          'description' => _t('Can edit all collections, not just own collections.'),
        ),
        'can_edit_all_ca_storage_locations' => array(
          'label' => _t('Edit all storage locations'),
          'description' => _t('Can edit all storage_locations, not just own storage_locations.'),
        ),
        'can_edit_all_ca_loans' => array(
          'label' => _t('Edit all loans'),
          'description' => _t('Can edit all loans, not just own loans.'),
        ),
        'can_edit_all_ca_movements' => array(
          'label' => _t('Edit all movements'),
          'description' => _t('Can edit all movements, not just own movements.'),
        ),
        'can_edit_all_ca_tours' => array(
          'label' => _t('Edit all tours'),
          'description' => _t('Can edit all tours, not just own tours.'),
        ),
        'can_edit_all_ca_tour_stops' => array(
          'label' => _t('Edit all tour stops'),
          'description' => _t('Can edit all tour stops, not just own tour stops.'),
        ),
			);
    }
		# -------------------------------------------------------
	}