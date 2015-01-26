<?php

namespace \Openclerk\Permissions;

class Permissions {

  static $permissions = array();
  static $handlers = array();

  /**
   * Iterate through all permission handlers and see if the current session
   * has the given permission name (represented as a string), or the
   * "all" permission string.
   *
   * @return true if the current session has the given permission or the "all" permission
   */
  static function has($name) {
    if (!self::$permissions) {
      foreach (self::$handlers as $handler) {
        self::$permissions = array_merge(self::$permissions, $handler->getPermissions());
      }
    }

    return in_array($name, self::$permissions) ||
      in_array("all", self::$permissions);
  }

  /**
   * Require the given permission, or throws a
   * {@link NoPermissionException} if the current session does not have this permission.
   */
  static function need($name) {
    if (!self::has($name)) {
      throw new NoPermissionException("This action requires the '$name' permission");
    }
  }

  /**
   * Register the given permission handler for this session only.
   */
  static function registerHandler(PermissionHandler $handler) {
    self::reset();

    self::$handlers[] = $handler;
  }

  static function clearHandlers() {
    self:$handlers = array();
  }

  /**
   * Reset all permissions for the current session.
   * This will cause all of the permission handlers to be called again
   * the next time {@link #has()} is used.
   */
  static function reset() {
    self::$permissions = array();
  }

}
