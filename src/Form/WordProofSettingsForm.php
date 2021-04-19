<?php


namespace Drupal\wordproof_timestamp\Form;


use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\wordproof_timestamp\Plugin\BlockchainBackendManager;

class WordProofSettingsForm extends ConfigFormBase {

  const SETTINGS = 'wordproof_timestamp.settings';

  /**
   * @var \Drupal\wordproof_timestamp\Plugin\BlockchainBackendManager
   */
  private $backendManager;

  /**
   * @var \Drupal\wordproof_timestamp\Plugin\StamperManager
   */
  private $stamperManager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  private $entityTypeBundleInfo;

  /**
   * WordProofSettingsForm constructor.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->backendManager = \Drupal::service('plugin.manager.wordproof_blockchain_backend');
    $this->stamperManager = \Drupal::service('plugin.manager.wordproof_stamper');
    $this->entityTypeManager = \Drupal::service('entity_type.manager');
    $this->entityTypeBundleInfo = \Drupal::service('entity_type.bundle.info');

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

    $blockchainBackendDefinitions = $this->backendManager->getDefinitions();
    $blockchainBackendOptions = array_reduce(
      $blockchainBackendDefinitions,
      function (array $carry, array $definition) {
        $carry[$definition['id']] = $definition['title'];
        return $carry;
      },
      []
    );
    ksort($blockchainBackendOptions);

    $form['blockchain_backend_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Blockchain backend'),
      '#default_value' => $config->get('wordproof_api_backend_queued') ?: 'wordproof_api_backend_queued',
      '#options' => $blockchainBackendOptions,
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

    $stamperDefinitions = $this->stamperManager->getDefinitions();
    $stamperOptions = array_reduce(
      $stamperDefinitions,
      function (array $carry, array $definition) {
        $carry[$definition['id']] = $definition['title'];
        return $carry;
      },
      []
    );
    ksort($stamperOptions);


    $form['stamper_table'] = array(
      '#type' => 'table',
      '#caption' => t('Configure entity timestamps'),
      '#header' => array(t('Entity'), t('Enable'), t('Stamper plugin'))
    );

    $entityTypeDefinitions = $this->entityTypeManager->getDefinitions();
    $contentEntityBundleInfo = array_filter($this->entityTypeBundleInfo->getAllBundleInfo(), function($key) use ($entityTypeDefinitions){
      return $entityTypeDefinitions[$key] instanceof ContentEntityTypeInterface && $key !== 'timestamp';
    }, ARRAY_FILTER_USE_KEY);

    foreach($contentEntityBundleInfo as $entity_type => $bundleInfo){
      foreach($bundleInfo as $bundle => $label){
        $stamperFormId = 'stamper.' . $entity_type . '-' . $bundle;

        $entity_type_obj = $entityTypeDefinitions[$entity_type];

        $form['stamper_table'][$stamperFormId][$stamperFormId . '_entity_label']['#plain_text'] = $label['label'] . ' ('. $entity_type . '-' . $bundle. ')';

        $form[$stamperFormId . '.entity_type'] = [
          '#type' => 'hidden',
          '#title' => $this->t('Entity type'),
          '#default_value' => $entity_type,
        ];
        $form[$stamperFormId . '.entity_type_bundle'] = [
          '#type' => 'hidden',
          '#title' => $this->t('Entity type bundle'),
          '#default_value' => $bundle,
        ];
        $form['stamper_table'][$stamperFormId][$stamperFormId . '.enabled'] = [
          '#type' => 'checkbox',
          '#title' => $this->t('Enable stamping'),
          '#default_value' => $config->get($stamperFormId . '.enabled')
        ];
        $form['stamper_table'][$stamperFormId][$stamperFormId . '.plugin_id'] = [
          '#type' => 'select',
          /*'#title' => $this->t('Stamper plugin:'),*/
          '#default_value' => $config->get($stamperFormId . '.plugin_id') ?: '',
          '#options' => $stamperOptions,
          '#attributes' => [
            'id' => $stamperFormId . '.plugin_id',
          ],
          '#states' => [
            //show this textfield only if the radio 'other' is selected above
            'visible' => [
              //don't mistake :input for the type of field. You'll always use
              //:input here, no matter whether your source is a select, radio or checkbox element.
              // ':input[name="' . $stamperFormId . '_enabled"]' => ['checked' => TRUE],
              ':input[name="stamper_table[' . $stamperFormId . '][' . $stamperFormId . '.enabled]"]' => ['checked' => TRUE],
            ],
          ],
        ];



      }
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable(static::SETTINGS);
    $config
      ->set('blockchain_backend_id', $form_state->getValue('blockchain_backend_id'))
      ->set('blockchain_backend_key', $form_state->getValue('blockchain_backend_key'))
      ->set('blockchain_backend_url', $form_state->getValue('blockchain_backend_url'));

    $values = $form_state->getValues();
    $stampers = $form_state->getValue('stamper_table');
    foreach($stampers as $stamperId => $values){
      $config->set($stamperId . '.enabled', $values[$stamperId . '.enabled']);
      if($values[$stamperId . '.enabled']){
        $config->set($stamperId . '.plugin_id', $values[$stamperId . '.plugin_id']);
        $config->set($stamperId . '.entity_type', $form_state->getValue($stamperId . '.entity_type'));
        $config->set($stamperId . '.entity_type_bundle', $form_state->getValue($stamperId . '.entity_type_bundle'));
      }
    }
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
