<?php

namespace Openclerk\Permissions;

interface PermissionHandler {

  /**
   * Return the list of permissions (as strings) that the user currently has.
   * May return the permission "all" to represent permissions for everything.
   */
  public function getPermissions();

}
