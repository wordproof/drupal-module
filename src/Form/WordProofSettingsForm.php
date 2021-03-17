<?php


namespace Drupal\wordproof\Form;


use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\wordproof\Plugin\BlockchainBackendManager;

class WordProofSettingsForm extends ConfigFormBase {

  const SETTINGS = 'wordproof.settings';

  /**
   * @var \Drupal\wordproof\Plugin\BlockchainBackendManager
   */
  private $backendManager;

  /**
   * WordProofSettingsForm constructor.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->backendManager = \Drupal::service('plugin.manager.wordproof_blockchain_backend');

    parent::__construct($config_factory);
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wordproof_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $definitions = $this->backendManager->getDefinitions();
    $options = array_reduce(
      $definitions,
      function (array $carry, array $definition) {
        $carry[$definition['id']] = $definition['title'];
        return $carry;
      },
      []
    );

    $form['blockchain_backend_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Blockchain backend'),
      '#default_value' => $config->get('wordproof_api_backend_queued') ?: 'wordproof_api_backend_queued',
      '#options' => $options,
    ];
    $form['blockchain_backend_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Blockchain backend key'),
      '#default_value' => $config->get('blockchain_backend_key') ?: null,
    ];
    $form['blockchain_backend_url'] = [
      '#type' => 'url',
      '#default_value' => $config->get('blockchain_backend_url') ?: 'https://api.wordproof.com/',
      '#title' => $this->t('Blockchain backend url'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('blockchain_backend_id', $form_state->getValue('blockchain_backend_id'))
      ->set('blockchain_backend_key', $form_state->getValue('blockchain_backend_key'))
      ->set('blockchain_backend_url', $form_state->getValue('blockchain_backend_url'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
