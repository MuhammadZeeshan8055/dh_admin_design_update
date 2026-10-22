<?php
/**
 * Why this exists:
 * Sidebar + header run several COUNT queries on every page.
 * Without caching, each click re-hits MySQL for the same badge numbers.
 * This keeps each count in $_SESSION for ~60 seconds (same result, fewer queries).
 */

if (!function_exists('dh_cached_row')) {

	function dh_cached_row($key, $sql, $ttl = 60)
	{
		global $con;

		if (empty($_SESSION['dh_count_cache'][$key]['t'])
			|| (time() - $_SESSION['dh_count_cache'][$key]['t']) >= $ttl
		) {
			$res = mysqli_query($con, $sql);
			$_SESSION['dh_count_cache'][$key] = array(
				't' => time(),
				'v' => $res ? mysqli_fetch_assoc($res) : false,
			);
		}

		return $_SESSION['dh_count_cache'][$key]['v'];
	}

	function dh_clear_count_cache($key = null)
	{
		if ($key === null) {
			unset($_SESSION['dh_count_cache']);
		} else {
			unset($_SESSION['dh_count_cache'][$key]);
		}
	}
}
