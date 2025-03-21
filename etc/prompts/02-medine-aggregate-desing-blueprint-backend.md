You are an expert programmer and a DDD expert. You'll be given a MedineTech's Aggregate Design Blueprint and have to transform it to HTTP controllers and request files.

## Instructions to transform the Aggregate Design Blueprint to HTTP controllers:

They take into account what you do in the file etc/prompts/01-medine-aggregate-desing-blueprint-backend.md directory. You have to create:

- A controllers module for the aggregate:
  - The module name should be the name of the aggregate in plural.
  - Should be written in `$FOLDERS_CASE`.
  - Should be inside the `app/Http/Controllers/Backoffice/$CONTEXT_NAME` directory.

Inside the controllers module, you'll have to create:
  - A `${AGGREGATE_NAME}PostController.$FILES_FORMAT` file for creating the aggregate:
    - The file should include OpenAPI documentation for the endpoint.
    - The controller should validate the request data.
    - The controller should handle permissions using the appropriate permissions class.
    - The controller should use DB transactions for data integrity.
    - The controller should return appropriate HTTP responses.
    - You should take a look to other controllers to see the format.

  - A `${AGGREGATE_NAME}GetController.$FILES_FORMAT` file for finding the aggregate by ID:
    - The file should include OpenAPI documentation for the endpoint.
    - The controller should handle permissions using the appropriate permissions class.
    - The controller should handle "not found" exceptions.
    - The controller should return appropriate HTTP responses.
    - You should take a look to other controllers to see the format.

  - A `${AGGREGATE_NAME}sGetController.$FILES_FORMAT` file for searching/listing aggregates:
    - The file should include OpenAPI documentation for the endpoint.
    - The controller should handle permissions using the appropriate permissions class.
    - The controller should handle pagination and filtering.
    - The controller should return appropriate HTTP responses.
    - You should take a look to other controllers to see the format.

  - A `${AGGREGATE_NAME}PutController.$FILES_FORMAT` file for updating the aggregate:
    - The file should include OpenAPI documentation for the endpoint.
    - The controller should validate the request data.
    - The controller should handle permissions using the appropriate permissions class.
    - The controller should use DB transactions for data integrity.
    - The controller should handle "not found" exceptions.
    - The controller should return appropriate HTTP responses.
    - You should take a look to other controllers to see the format.

- A routes file for the aggregate:
  - The module name should be the name of the aggregate in plural.
  - The file should be written in `$FOLDERS_LOWERCASE`.
  - The file should be located at `routes/backoffice/$CONTEXT_NAME` directory.
  - The routes should follow RESTful patterns.
  - The routes should be named appropriately.
  - Consult other routes files for the format.

- HTTP request files for testing the API:
  - The module name must be the singular name of the aggregate.
  - Should be written in `$FOLDERS_LOWERCASE`.
  - The files should be located at `etc/http/backoffice/$CONTEXT_NAME directory`.
  - Create separate .http files for each endpoint (create, find, search, update).
  - Each file should include:
    - The appropriate HTTP verb (GET, POST, PUT, etc.)
      - For example, for the PostController, it is `accounting-account-POST.$FILES_HTTP`.
      - For the GetController and sGetController, it is `accounting-account-GET.$FILES_HTTP`.
      - For the PutController, it is `accounting-account-PUT.$FILES_HTTP`.
    - The correct URL path
    - Headers including authorization token placeholder
    - Request body with example data in JSON format
    - Comments explaining the purpose of the request
  - In the `app/Providers/AppServiceProvider.php` file, in the `register()` method, add the repository and the repository implementation you created from the module. Follow the same format as the other modules.
    - Import the repositories with the "use" command.
  - Follow the format of the existing `.$FILES_HTTP` files in the project.

## Protocol to execute the transformation:

1. Search for the examples of the files that you have to create in the project
  - Execute tree to see the current file structure. Then use cat to see the content of similar files.

2. Create the controller files structure
  - If the controller folder doesn't exist, create it.

3. Create each controller file one by one:
  - Start with the PostController for creating the aggregate.
  - Then create the GetController for retrieving a single aggregate.
  - Then create the sGetController for listing/searching aggregates.
  - Finally, create the PutController for updating the aggregate.

4. Create the routes file
  - Define all the necessary routes for the controllers.

5. Create the HTTP request files
  - Create a `.$FILES_HTTP` file for each endpoint (create, find, search, update).
  - Include proper headers, request bodies, and example data.

### User variables:
- $FOLDERS_CASE = PascalCase
- $FILES_FORMAT = php
- $FILES_HTTP = http
- $FOLDERS_LOWERCASE = lowercase
- $FOLDERS_KEBABCASE = kebab-case
