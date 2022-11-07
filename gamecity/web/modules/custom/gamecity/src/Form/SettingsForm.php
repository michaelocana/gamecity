<?php

namespace Drupal\gamecity\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure form for API Settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'gamecity_api_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['gamecity.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('gamecity.settings');

    $form['gamecity'] = array(
        '#type'         => 'details', 
        '#title'        => t('API Administration Form'),
        '#open' => TRUE, 
      );
    
      $form['gamecity']['gamecity_api_key'] = array(
        '#type'             => 'textfield',
        '#title'            => t('API Key'),
        '#default_value'    => $config->get('gamecity_api_key'),
        '#required'         => TRUE,
        '#min' => 0,
        '#size'             => 128,
      );
    
      $form['gamecity']['gamecity_api_secret'] = array(
        '#type'             => 'textfield',
        '#title'            => t('API Secret'),
        '#default_value'    => $config->get('gamecity_api_secret'),
        '#required'         => TRUE,
        '#min' => 0,
        '#size'             => 128,  
      );
    

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('gamecity.settings')
      ->set('gamecity_api_key', $form_state->getValue('gamecity_api_key'))
      ->set('gamecity_api_secret', $form_state->getValue('gamecity_api_secret'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
