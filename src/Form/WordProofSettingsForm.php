<?php

namespace Drupal\wordproof\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\wordproof\Plugin\BlockchainBackendManager;
use Drupal\wordproof\Plugin\StamperManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Settings form for WordProof.
 */
class WordProofSettingsForm extends ConfigFormBase {

  const SETTINGS = 'wordproof.settings';

  /**
   * @var \Drupal\wordproof\Plugin\BlockchainBackendManager
   */
  protected $backendManager;

  /**
   * @var \Drupal\wordproof\Plugin\StamperManager
   */
  protected $stamperManager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * WordProofSettingsForm constructor.
   */
  public function __construct(ConfigFactoryInterface $config_factory, BlockchainBackendManager $backendManager, StamperManager $stamperManager, EntityTypeManagerInterface $entityTypeManager, EntityTypeBundleInfoInterface $entityTypeBundleInfo) {
    parent::__construct($config_factory);

    $this->backendManager = $backendManager;
    $this->stamperManager = $stamperManager;
    $this->entityTypeManager = $entityTypeManager;
    $this->entityTypeBundleInfo = $entityTypeBundleInfo;
  }

  /**
   * Create the form with correct services.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container.
   *
   * @return \Drupal\Core\Form\ConfigFormBase|\Drupal\wordproof\Form\WordProofSettingsForm|static
   *   Return wordproof settings form
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('plugin.manager.wordproof_blockchain_backend'),
      $container->get('plugin.manager.wordproof_stamper'),
      $container->get('entity_type.manager'),
      $container->get('entity_type.bundle.info')
    );
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

    $form['enable_revisions'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show revisions'),
      '#default_value' => $config->get('enable_revisions') ?: 0,
      '#required' => FALSE,
    ];

    $form['blockchain_backend_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Blockchain backend'),
      '#default_value' => $config->get('wordproof_api_backend_queued') ?: 'wordproof_api_backend_queued',
      '#options' => $blockchainBackendOptions,
    ];
    $form['blockchain_backend_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Blockchain backend key'),
      '#default_value' => $config->get('blockchain_backend_key') ?: NULL,
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

    $form['stamper_table'] = [
      '#type' => 'table',
      '#caption' => $this->t('Configure entity timestamps'),
      '#header' => [$this->t('Entity'), $this->t('Enable'), $this->t('Stamper plugin')],
    ];

    $entityTypeDefinitions = $this->entityTypeManager->getDefinitions();
    $contentEntityBundleInfo = array_filter($this->entityTypeBundleInfo->getAllBundleInfo(), function ($key) use ($entityTypeDefinitions) {
      return $entityTypeDefinitions[$key] instanceof ContentEntityTypeInterface && $key !== 'wordproof';
    }, ARRAY_FILTER_USE_KEY);

    foreach ($contentEntityBundleInfo as $entity_type => $bundleInfo) {
      foreach ($bundleInfo as $bundle => $label) {
        $stamperFormId = 'stamper.' . $entity_type . '-' . $bundle;

        $form['stamper_table'][$stamperFormId][$stamperFormId . '_entity_label']['#plain_text'] = $label['label'] . ' (' . $entity_type . '-' . $bundle . ')';

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
          '#default_value' => $config->get($stamperFormId . '.enabled'),
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
            // Show this textfield only if the radio 'other' is selected above.
            'visible' => [
              // don't mistake :input for the type of field. You'll always use
              // :input here, no matter whether your source is a select, radio or checkbox element.
              // ':input[name="' . $stamperFormId . '_enabled"]' => ['checked' => TRUE],.
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
      ->set('blockchain_backend_url', $form_state->getValue('blockchain_backend_url'))
      ->set('enable_revisions', $form_state->getValue('enable_revisions'));

    $values = $form_state->getValues();
    $stampers = $form_state->getValue('stamper_table');
    foreach ($stampers as $stamperId => $values) {
      $config->set($stamperId . '.enabled', $values[$stamperId . '.enabled']);
      if ($values[$stamperId . '.enabled']) {
        $config->set($stamperId . '.plugin_id', $values[$stamperId . '.plugin_id']);
        $config->set($stamperId . '.entity_type', $form_state->getValue($stamperId . '.entity_type'));
        $config->set($stamperId . '.entity_type_bundle', $form_state->getValue($stamperId . '.entity_type_bundle'));
      }
    }
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
