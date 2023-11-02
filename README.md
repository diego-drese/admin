Certainly! Here's the documentation formatted in Markdown for your README:

### Table `resources`

The `resources` table stores information about the resources (or permissions) available in your system. These resources are used to control user access to specific parts of your application.

- `id` (bigint): Unique identifier for each resource.
- `name` (varchar): The descriptive name of the resource.
- `is_menu` (tinyint): Indicates whether the resource is a menu item.
- `route_name` (varchar): The name of the route associated with this resource (if applicable).
- `controller_method` (varchar): The method of the controller associated with this resource.
- `can_be_default` (tinyint): Indicates whether the resource can be a default setting.
- `parent_id` (bigint): Identifier of the parent resource (if applicable).
- `order` (int): The display order of this resource.
- `created_at` (timestamp): Date and time of resource creation.
- `updated_at` (timestamp): Date and time of the last resource update.

### Table `role_has_resources`

The `role_has_resources` table is an intermediate table that relates roles to specific resources. This determines which roles have access to which resources.

- `id` (bigint): Unique identifier for each relationship.
- `role_id` (bigint): Identifier of the role.
- `resource_id` (bigint): Identifier of the resource.
- `created_at` (timestamp): Date and time of the relationship creation.
- `updated_at` (timestamp): Date and time of the last relationship update.

### Table `roles`

The `roles` table stores information about the roles available in your system. Roles are used to group permissions and control user access to parts of the application.

- `id` (bigint): Unique identifier for each role.
- `name` (varchar): The descriptive name of the role.
- `status` (tinyint): Indicates the status of the role (active/inactive).
- `created_at` (timestamp): Date and time of role creation.
- `updated_at` (timestamp): Date and time of the last role update.

### Table `user_has_roles`

The `user_has_roles` table is an intermediate table that relates users to roles, defining which roles are assigned to each user.

- `id` (bigint): Unique identifier for each relationship.
- `role_id` (bigint): Identifier of the role.
- `user_id` (bigint): Identifier of the user.
- `created_at` (timestamp): Date and time of the relationship creation.
- `updated_at` (timestamp): Date and time of the last relationship update.

### Table `users`

The `users` table stores information about the users of your system.

- `id` (bigint): Unique identifier for each user.
- `name` (varchar): The user's name.
- `email` (varchar): The user's email address.
- `email_verified_at` (timestamp): Date and time of email address verification.
- `password` (varchar): The user's password (usually encrypted).
- `remember_token` (varchar): The token for authentication remember.
- `created_at` (timestamp): Date and time of user creation.
- `updated_at` (timestamp): Date and time of the last user update.
- `is_root` (tinyint): Indicates whether the user is a superuser (typically used for elevated privilege access).

---

This documentation is now available in both Portuguese (PT_BR) and English for your README in Markdown format. Feel free to use it in your documentation.