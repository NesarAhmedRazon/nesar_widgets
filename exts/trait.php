trait FindElementorData
{
  /**
   * Find Elementor data for current post
   * @param string $needle Name of data we are looking for
   * @param mixed|null $default Default value to return if nothing is found
   * @return mixed
   */
  protected function find_elementor_data(string $needle, $default = '')
  {
    $post = get_post();

    $meta = get_post_meta($post->ID);

    if (empty($meta) === true) {
      return $default;
    }

    if (empty($meta['_elementor_data']) === true) {
      return $default;
    }

    foreach ($meta['_elementor_data'] as $data) {

      $arr = json_decode($data);

      $value = $this->find_recursively($arr, $needle);

      if (isset($value)) {

        return $value;
      }
    }

    return $default;
  }

  protected function find_recursively(array $haystack, $needle)
  {
    $iterator  = new RecursiveArrayIterator($haystack);

    $recursive = new RecursiveIteratorIterator(
      $iterator,
      RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($recursive as $key => $value) {
      if ($key === $needle) {
        return $value;
      }
    }
  }
}