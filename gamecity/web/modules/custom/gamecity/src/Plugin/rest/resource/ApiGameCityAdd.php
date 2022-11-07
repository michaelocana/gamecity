<?php

namespace Drupal\gamecity\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\node\Entity\Node;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "api_gamecity_add",
 *   label = @Translation("Game City API Add games"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/gamecity/add/game",
 *     "create" = "/api/v1/gamecity/add/game"   
 *   }
 * )
 */
class ApiGameCityAdd extends ResourceBase {

    /**
     * A current user instance.
     *
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $currentUser;

    /**
     * Constructs a Drupal\rest\Plugin\ResourceBase object.
     *
     * @param array $configuration
     *   A configuration array containing information about the plugin instance.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     * @param array $serializer_formats
     *   The available serialization formats.
     * @param \Psr\Log\LoggerInterface $logger
     *   A logger instance.
     * @param \Drupal\Core\Session\AccountProxyInterface $current_user
     *   A current user instance.
     */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $current_user)
    {
      parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
      $this->currentUser = $current_user;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->getParameter('serializer.formats'),
            $container->get('logger.factory')->get('gamecity'),
            $container->get('current_user')
        );
    }

    /** * {@inheritdoc} */
    public function permissions() {
      return [];
    }

    public function post($data) {
      if (!$data['category']) {
        $response = ['status' => 'error', 'data' => 'Missing category'];
      } else {
        $category = $this->_api_gamecity_validate_category($data['category']);

        if ($category) {
          $game = Node::create([
            'type' => 'games',
            'title' => $data['title'],
            'field_description' => $data['description'],
            'field_category' => $category->id(),
          ]);
          $game->save();

          if ($game) {
            $response = ['status' => 'success!', 'data' => $game];
          } else {
            $response = ['status' => 'error', 'data' => []];
          }           
        } else {
          $response = ['status' => 'error', 'data' => 'Invalid category'];
        }
      }

      return  new ResourceResponse($response);
    }

    private function _api_gamecity_validate_category($category) {
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')
        ->loadByProperties(['name' => $category, 'vid' => 'category']);
      $term = reset($term); 

      return $term;  
    }
}
