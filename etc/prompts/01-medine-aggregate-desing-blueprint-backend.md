You are an expert programmer and a DDD expert. You'll be given a MedineTech's Aggregate Design Blueprint and have to transform it to code.

## Instructions to transform the Aggregate Design Blueprint to code:

You have to create:

- A module for the aggregate:
  - The module name should be the name of the aggregate in plural.
  - Should be written in `$FOLDERS_CASE`.
  - Should be inside the `src/Backoffice/$CONTEXT_NAME` directory.
- Every module contains 3 folders: `Domain`, `Application`, and `Infrastructure`.
  Inside the Domain folder, you'll have to create:
    - An `$AGGREGATE_NAME.$FILES_FORMAT` file that contains the aggregate class:
      - The file name should be the name of the aggregate in PascalCase.
      - The aggregate class should have the properties, invariants, policies, and events that the aggregate has. 
      - You should take a look to other aggregates to see the format.
    - A `$DOMAIN_EVENT.$FILES_FORMAT` file per every event that the aggregate emits:
      - The file name should be the name of the event in PascalCase. 
      - The event should have only the mutated properties.
      - You should take a look to other events to see the format.
    - A `$REPOSITORY.$FILES_FORMAT` file that contains the repository interface:
      - The file name should be the name of the aggregate in PascalCase with the suffix Repository.
      - The repository should have the methods to save and retrieve the aggregate.
      - You should take a look to other repositories to see the format.
    - Inside the Application folder, you'll have to create:
      - A folder using `$FOLDERS_CASE` for every mutation that the aggregate has (inferred by the domain events) and for every query that the aggregate has.
      - Inside every query/mutation folder, you'll have to create an `$USE_CASE.$FILES_FORMAT` file that contains the query/mutation use case.
        - The file name should be the name of the query/mutation in PascalCase in a service mode. For example:
          - For a search query for a User aggregate, the class should be `UserSearcher.$FILES_FORMAT`.
          - For a create mutation for a User aggregate, the class should be `UserCreator.$FILES_FORMAT`.
          - For an update mutation for a User aggregate, the class should be `UserUpdater.$FILES_FORMAT`.
          - For a find mutation for a User aggregate, the class should be `UserFinder.$FILES_FORMAT`.
        - You should take a look to other queries/mutations to see the format.
    - Inside the `Infrastructure` folder, you'll have to create:
      - A `$REPOSITORY.$FILES_FORMAT` file that contains the repository implementation:
        - The file name should be the name of the aggregate in PascalCase with the suffix Repository.
        - Also, the file should have an implementation prefix. For example, for a User aggregate and a Eloquent implementation, the file should be `EloquentUserRepository.$FILES_FORMAT`.
        - The repository should implement the repository interface from the domain layer.
        - You should take a look to other repositories to see the format and use the most used implementation.
    - You'll have to create a test per every use case:
      - The test should be inside the `tests/Backoffice/$CONTEXT_NAME/$MODULE_NAME/Application` directory.
      - You should create an Object Mother per every aggregate and value object that you create inside `tests/Backoffice/$CONTEXT_NAME/$MODULE_NAME/Domain`.
      - Take a look inside the `tests/Backoffice` folder to see the format of the Object Mothers and the tests.
      - You should only create a test per every use case, don't create any extra test case.

## Protocol to execute the transformation:

1. Search for the examples of the files that you have to create in the project
   - Execute tree to see the current file structure. Then use cat to see the content of similar files.

2. Verify all files
   - Check all files to see if they meet their respective functionality, such as repository implementation, use cases, domain, etc.
   - Review all project files and maintain the same structure.

2. Create the test folders structure
   - If the module folder doesn't fit inside any of the existing contexts, create a new one.

3. Create the test for the first use case
   - We should create use case by use case, starting with the first one.
   - We're doing TDD, so we'll create the first use case test first.
   - Also, we'll create all the object mothers.
   - Then all the domain objects (if needed).
   - Then the use case.
   - Do this until the test created passes the test with the `make test` command.
   - Repeat this per every use case.

### User variables:
   - $FOLDERS_CASE = PascalCase
   - $FILES_FORMAT = php
