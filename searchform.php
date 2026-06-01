<?php
/**
 * Form di ricerca
 *
 * @package lanotte-2026
 */
if (!defined('ABSPATH')) exit;
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" style="display:flex;gap:8px">
  <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Cerca…" required style="flex:1;padding:11px 14px;border:1px solid var(--border);background:#fff;border-radius:2px;font-family:inherit;font-size:14px">
  <button type="submit" class="btn btn-primary" style="padding:11px 18px">Cerca</button>
</form>
