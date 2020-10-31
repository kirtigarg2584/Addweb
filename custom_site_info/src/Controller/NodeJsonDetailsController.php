<?php

namespace Drupal\custom_site_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Controller for Json representation for nodes of content type page.
 */
class NodeJsonDetailsController extends ControllerBase {

  /**
   * Function to return Drupal plans.
   */
  public function nodeJsonDetails($site_api_key,$nid) {
    $api_key_site = \Drupal::config('system.site')->get('siteapikey');
    if($api_key_site == $site_api_key){
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      if($node && $node->get('type')->getValue()[0]['target_id']=='page'){
        $node_data = Json::encode([
          'id' => $node->id(),
          'type' => $node->getType(),
          'title' => $node->getTitle(),
          'body' => strip_tags($node->get('body')->getValue()[0]['value'])
        ]);
        return new JsonResponse(['data' => $node_data]);
      }
      else{
        \Drupal::messenger('custom_site_info')->addError('Access Denied');
      }
      return [];
    }
    \Drupal::messenger('custom_site_info')->addError('Access Denied');
    return [];
  }

}
