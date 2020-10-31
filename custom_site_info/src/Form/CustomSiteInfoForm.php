<?php

namespace Drupal\custom_site_info\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Custom site info form.
 *
 * @ingroup custom_site_info
 */
class CustomSiteInfoForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);
    // Adding new field in the form.
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
			'#description' => $this->t("Custom field to set the API Key"),
		];
    // Updating the value of the Save Configuration button acc to Site API Key.
    if($site_config->get('siteapikey'))
      $form['actions']['submit']['#value']='Update Configuration';
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
    parent::submitForm($form, $form_state);
    // Custom Drupal message for user.
    \Drupal::messenger('custom_site_info')->addMessage('Site API Key has been saved with value : ' . $form_state->getValue('siteapikey'));
  }

}
