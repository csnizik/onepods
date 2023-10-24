FarmOS modifies Drupal's out-of-the-box roles and permissions system in several ways. Before using them, it is important to understand what farmOS is doing.

- **Managed roles**: FarmOS introduces a concept to Drupal called "Managed Roles", which are roles that are programattically defined, rather than using the admin UI as a typical Drupal site does. Roles can be given a granular level of permissions, such as "View all {entity type}" or "View own {entity type}", etc.
- **OAuth integration**: (this assumes that EAuth gives us the same or similar functionality that OAuth does) FarmOS maps OAuth scopes to Drupal roles (both "Managed" and "Unmanaged", which are typical Drupal roles). FarmOS uses the [Consumers](https://www.drupal.org/project/consumers) module: it creates and configures a "Consumer" for each OAuth client, which then links the client to a role.
- **API consumers**: this approach allows FarmOS to use the same permissions system for users accessing the site via an API endpoint as for browser users of the website.

### Defining custom roles

FarmOS provides comprehensive documentation for creating new custom roles and adding permissions to roles using a `permission_callback`. The documentation is at `./web/profiles/contrib/farmos/docs/development/module/roles.md` and gives examples.

### Do we want to integrate Drupal roles with the eAuth system?

As long as we understand and work with FarmOS's implementation of Drupal's roles and permissions system, yes; it will allow us to provide a detailed and nuanced access control system with a reasonable LOE.
