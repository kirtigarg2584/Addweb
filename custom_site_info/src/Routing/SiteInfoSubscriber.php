<?php

namespace Drupal\custom_site_info\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Subscriber for dynamic route events.
 */
class SiteInfoSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('system.site_information_settings')) 
      $route->setDefault('_form', 'Drupal\custom_site_info\Form\CustomSiteInfoForm');
  }

}