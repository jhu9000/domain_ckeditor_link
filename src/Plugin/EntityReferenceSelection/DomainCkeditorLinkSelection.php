<?php

namespace Drupal\domain_ckeditor_link\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;
use Drupal\domain_access\DomainAccessManagerInterface;

/**
 * Returns matching nodes with domain assignment to the active domain.
 *
 * @EntityReferenceSelection(
 *   id = "domain_ckeditor_link:node",
 *   label = @Translation("Domain Ckeditor Link"),
 *   entity_types = {"node"},
 *   group = "default",
 *   weight = 1,
 * )
 */
class DomainCkeditorLinkSelection extends DefaultSelection {

  /**
   * {@inheritdoc}
   */
  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS') {
    $query = parent::buildEntityQuery($match, $match_operator);
    $config = $this->getConfiguration();
    $domain_id = $config['domain_id'] ?? NULL;
    if (!empty($domain_id)) {
      $group = $query->orConditionGroup()
        ->condition(DomainAccessManagerInterface::DOMAIN_ACCESS_FIELD, $domain_id, '=')
        ->condition(DomainAccessManagerInterface::DOMAIN_ACCESS_ALL_FIELD, '1');
      $query->condition($group);
    }
    return $query;
  }

}
