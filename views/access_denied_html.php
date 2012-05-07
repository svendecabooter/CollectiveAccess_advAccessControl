<?php
  $redirect = $this->getVar('redirect_url');
?>

<h1><?php print _t("Access Denied"); ?></h1>
<a href="<?php print $redirect; ?>"><?php print _t('Click here to view the summary of this object'); ?></a>
