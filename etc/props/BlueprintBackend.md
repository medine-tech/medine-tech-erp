# Index

* **Context:** Accounting
* **Module:** Accounting Accounts
* **Current PHP version:** 8.2

## Medine Tech Aggregate Blueprint Backend structure:

* **Name**: AccountingAccount
* **Description**: Represents an accounting account within the accounting module. It includes details such as code, name, description, type, status, and relationships with other accounts (e.g., parent account).
* **Context**: Accounting
* **Module**: Accounting Accounts

* **Properties**:
    - `id` (string): Unique identifier for the account.
    - `code` (string): Unique code for the account.
    - `name` (string): Name of the account.
    - `description` (string, nullable): Description of the account.
    - `type` (int): Type of the account (e.g., asset, liability, equity, revenue, expense).
    - `status` (string): Status of the account (e.g., active, inactive).
    - `parentId` (string, nullable): Identifier of the parent account, if any.
    - `creatorId` (int): Identifier of the user who created the account.
    - `updaterId` (int): Identifier of the user who last updated the account.
    - `companyId` (string): Identifier of the company associated with the account.

* **Relationships**:
    - `Company`: An accounting account belongs to a company (`companyId`).
    - `User`: An accounting account has a creator and an updater (`creatorId`, `updaterId`).
    - `ParentAccount`: An accounting account can have a parent account (`parentId`).

* **Enforced Invariants**:
    - The `code` must be unique within the same company.
    - The `type` must be one of the predefined values (asset, liability, equity, revenue, expense).
    - The `status` must be either "active" or "inactive".
    - The `parentId` must reference a valid account if provided.
    - The `creatorId` and `updaterId` must reference valid users.
    - The `companyId` must reference a valid company.

* **Corrective Policies**:
    - If an invalid `type` is provided, the system defaults to "expense".
    - If an invalid `status` is provided, the system defaults to "inactive".
    - If a `parentId` is provided but does not reference a valid account, the system removes the reference.

* **Business Rules**:
    - An accounting account cannot be its own parent account.
    - An accounting account cannot change its type if it has associated transactions.
    - Only users with specific permissions can create or modify accounting accounts.

* **Domain Events**:
    - `AccountingAccountCreatedDomainEvent`: Emitted when a new accounting account is created.
        - Properties: `id`, `code`, `name`, `description`, `type`, `status`, `parentId`, `creatorId`, `updaterId`, `companyId`.
    - `AccountingAccountUpdatedDomainEvent`: Emitted when an existing accounting account is updated.
        - Properties: `id`, `name`, `description`, `type`, `status`, `parentId`, `updaterId`.

* **Ways to Access**:
    - **Search**: Retrieve a list of accounting accounts based on filters (e.g., by company, status, or type).
    - **Find**: Retrieve a specific accounting account by its unique identifier.
    - **Create**: Add a new accounting account to the system.
    - **Update**: Modify an existing accounting account.

* **Dependencies**:
    - Authentication service: To validate user permissions (`creatorId`, `updaterId`).
    - Notification service: To send notifications when an account is created or updated.

* **Performance Considerations**:
    - Accounting account searches should be indexed by `companyId` and `type`.
    - Bulk updates should use transactions to ensure consistency.

* **Security Considerations**:
    - Only users with the `VIEW` permission can search accounting accounts.
    - Inactive accounting accounts should not be accessible to users without special permissions.

* **Testing**:
    - **Unit Tests**: Verify that invariants and corrective policies are applied correctly.
    - **Integration Tests**: Verify that the aggregate interacts correctly with the repository and other services.
    - **Acceptance Tests**: Verify that use cases (creation, update, search) work according to business requirements.

* **Maintenance and Evolution**:
    - **Versioning**: Use semantic versioning for changes in the accounting account schema.
    - **Deprecation**: Accounting accounts inactive for more than one year are marked as deprecated.

## API Guidelines

- [Principles](https://opensource.zalando.com/restful-api-guidelines/#principles)
    - [API design principles](https://opensource.zalando.com/restful-api-guidelines/#api-design-principles)
    - [API as a product](https://opensource.zalando.com/restful-api-guidelines/#api-as-a-product)
    - [API first](https://opensource.zalando.com/restful-api-guidelines/#api-first)
- [3. General guidelines](https://opensource.zalando.com/restful-api-guidelines/#general-guidelines)
    - [**MUST** follow API first principle](https://opensource.zalando.com/restful-api-guidelines/#100)
    - [**MUST** provide API specification using OpenAPI](https://opensource.zalando.com/restful-api-guidelines/#101)
    - [**SHOULD** provide API user manual](https://opensource.zalando.com/restful-api-guidelines/#102)
    - [**MUST** write APIs using U.S. English](https://opensource.zalando.com/restful-api-guidelines/#103)
    - [**MUST** only use durable and immutable remote references](https://opensource.zalando.com/restful-api-guidelines/#234)
- [4. REST Basics - Meta information](https://opensource.zalando.com/restful-api-guidelines/#meta-information)
    - [**MUST** contain API meta information](https://opensource.zalando.com/restful-api-guidelines/#218)
    - [**MUST** use semantic versioning](https://opensource.zalando.com/restful-api-guidelines/#116)
    - [**MUST** provide API identifiers](https://opensource.zalando.com/restful-api-guidelines/#215)
    - [**MUST** provide API audience](https://opensource.zalando.com/restful-api-guidelines/#219)
    - [**MUST**/**SHOULD**/**MAY** use functional naming schema](https://opensource.zalando.com/restful-api-guidelines/#223)
    - [**MUST** follow naming convention for hostnames](https://opensource.zalando.com/restful-api-guidelines/#224)
- [5. REST Basics - Security](https://opensource.zalando.com/restful-api-guidelines/#security)
    - [**MUST** secure endpoints](https://opensource.zalando.com/restful-api-guidelines/#104)
    - [**MUST** define and assign permissions (scopes)](https://opensource.zalando.com/restful-api-guidelines/#105)
    - [**MUST** follow the naming convention for permissions (scopes)](https://opensource.zalando.com/restful-api-guidelines/#225)
- [6. REST Basics - Data formats](https://opensource.zalando.com/restful-api-guidelines/#data-formats)
    - [**MUST** use standard data formats](https://opensource.zalando.com/restful-api-guidelines/#238)
    - [**MUST** define a format for number and integer types](https://opensource.zalando.com/restful-api-guidelines/#171)
    - [**MUST** use standard formats for date and time properties](https://opensource.zalando.com/restful-api-guidelines/#169)
    - [**SHOULD** select appropriate one of date or date-time format](https://opensource.zalando.com/restful-api-guidelines/#255)
    - [**SHOULD** use standard formats for time duration and interval properties](https://opensource.zalando.com/restful-api-guidelines/#127)
    - [**MUST** use standard formats for country, language and currency properties](https://opensource.zalando.com/restful-api-guidelines/#170)
    - [**SHOULD** use content negotiation, if clients may choose from different resource representations](https://opensource.zalando.com/restful-api-guidelines/#244)
    - [**SHOULD** only use UUIDs if necessary](https://opensource.zalando.com/restful-api-guidelines/#144)
- [7. REST Basics - URLs](https://opensource.zalando.com/restful-api-guidelines/#urls)
    - [**SHOULD** not use /api as base path](https://opensource.zalando.com/restful-api-guidelines/#135)
    - [**MUST** pluralize resource names](https://opensource.zalando.com/restful-api-guidelines/#134)
    - [**MUST** use URL-friendly resource identifiers](https://opensource.zalando.com/restful-api-guidelines/#228)
    - [**MUST** use kebab-case for path segments](https://opensource.zalando.com/restful-api-guidelines/#129)
    - [**MUST** use normalized paths without empty path segments and trailing slashes](https://opensource.zalando.com/restful-api-guidelines/#136)
    - [**MUST** keep URLs verb-free](https://opensource.zalando.com/restful-api-guidelines/#141)
    - [**MUST** avoid actions — think about resources](https://opensource.zalando.com/restful-api-guidelines/#138)
    - [**SHOULD** define *useful* resources](https://opensource.zalando.com/restful-api-guidelines/#140)
    - [**MUST** use domain-specific resource names](https://opensource.zalando.com/restful-api-guidelines/#142)
    - [**SHOULD** model complete business processes](https://opensource.zalando.com/restful-api-guidelines/#139)
    - [**MUST** identify resources and sub-resources via path segments](https://opensource.zalando.com/restful-api-guidelines/#143)
    - [**MAY** expose compound keys as resource identifiers](https://opensource.zalando.com/restful-api-guidelines/#241)
    - [**MAY** consider using (non-) nested URLs](https://opensource.zalando.com/restful-api-guidelines/#145)
    - [**SHOULD** limit number of resource types](https://opensource.zalando.com/restful-api-guidelines/#146)
    - [**SHOULD** limit number of sub-resource levels](https://opensource.zalando.com/restful-api-guidelines/#147)
    - [**MUST** use snake_case (never camelCase) for query parameters](https://opensource.zalando.com/restful-api-guidelines/#130)
    - [**MUST** stick to conventional query parameters](https://opensource.zalando.com/restful-api-guidelines/#137)
- [8. REST Basics - JSON payload](https://opensource.zalando.com/restful-api-guidelines/#json-guidelines)
    - [**MUST** use JSON as payload data interchange format](https://opensource.zalando.com/restful-api-guidelines/#167)
    - [**SHOULD** design single resource schema for reading and writing](https://opensource.zalando.com/restful-api-guidelines/#252)
    - [**SHOULD** be aware of services not fully supporting JSON/unicode](https://opensource.zalando.com/restful-api-guidelines/#250)
    - [**MAY** pass non-JSON media types using data specific standard formats](https://opensource.zalando.com/restful-api-guidelines/#168)
    - [**SHOULD** use standard media types](https://opensource.zalando.com/restful-api-guidelines/#172)
    - [**SHOULD** pluralize array names](https://opensource.zalando.com/restful-api-guidelines/#120)
    - [**MUST** property names must be snake_case (and never camelCase)](https://opensource.zalando.com/restful-api-guidelines/#118)
    - [**SHOULD** declare enum values using UPPER_SNAKE_CASE string](https://opensource.zalando.com/restful-api-guidelines/#240)
    - [**SHOULD** use naming convention for date/time properties](https://opensource.zalando.com/restful-api-guidelines/#235)
    - [**SHOULD** define maps using **`additionalProperties`**](https://opensource.zalando.com/restful-api-guidelines/#216)
    - [**MUST** use same semantics for **`null`** and absent properties](https://opensource.zalando.com/restful-api-guidelines/#123)
    - [**MUST** not use **`null`** for boolean properties](https://opensource.zalando.com/restful-api-guidelines/#122)
    - [**SHOULD** not use **`null`** for empty arrays](https://opensource.zalando.com/restful-api-guidelines/#124)
    - [**MUST** use common field names and semantics](https://opensource.zalando.com/restful-api-guidelines/#174)
    - [**MUST** use the common address fields](https://opensource.zalando.com/restful-api-guidelines/#249)
    - [**MUST** use the common money object](https://opensource.zalando.com/restful-api-guidelines/#173)
- [9. REST Basics - HTTP requests](https://opensource.zalando.com/restful-api-guidelines/#http-requests)
    - [**MUST** use HTTP methods correctly](https://opensource.zalando.com/restful-api-guidelines/#148)
    - [**MUST** fulfill common method properties](https://opensource.zalando.com/restful-api-guidelines/#149)
    - [**SHOULD** consider to design **`POST`** and **`PATCH`** idempotent](https://opensource.zalando.com/restful-api-guidelines/#229)
    - [**SHOULD** use secondary key for idempotent **`POST`** design](https://opensource.zalando.com/restful-api-guidelines/#231)
    - [**MAY** support asynchronous request processing](https://opensource.zalando.com/restful-api-guidelines/#253)
    - [**MUST** define collection format of header and query parameters](https://opensource.zalando.com/restful-api-guidelines/#154)
    - [**SHOULD** design simple query languages using query parameters](https://opensource.zalando.com/restful-api-guidelines/#236)
    - [**SHOULD** design complex query languages using JSON](https://opensource.zalando.com/restful-api-guidelines/#237)
    - [**MUST** document implicit response filtering](https://opensource.zalando.com/restful-api-guidelines/#226)
- [10. REST Basics - HTTP status codes](https://opensource.zalando.com/restful-api-guidelines/#http-status-codes-and-errors)
    - [**MUST** use official HTTP status codes](https://opensource.zalando.com/restful-api-guidelines/#243)
    - [**MUST** specify success and error responses](https://opensource.zalando.com/restful-api-guidelines/#151)
    - [**SHOULD** only use most common HTTP status codes](https://opensource.zalando.com/restful-api-guidelines/#150)
    - [**MUST** use most specific HTTP status codes](https://opensource.zalando.com/restful-api-guidelines/#220)
    - [**MUST** use code 207 for batch or bulk requests](https://opensource.zalando.com/restful-api-guidelines/#152)
    - [**MUST** use code 429 with headers for rate limits](https://opensource.zalando.com/restful-api-guidelines/#153)
    - [**MUST** support problem JSON](https://opensource.zalando.com/restful-api-guidelines/#176)
    - [**MUST** not expose stack traces](https://opensource.zalando.com/restful-api-guidelines/#177)
    - [**SHOULD** not use redirection codes](https://opensource.zalando.com/restful-api-guidelines/#251)
- [11. REST Basics - HTTP headers](https://opensource.zalando.com/restful-api-guidelines/#headers)
    - [Using Standard Header definitions](https://opensource.zalando.com/restful-api-guidelines/#using-headers)
    - [**MAY** use standard headers](https://opensource.zalando.com/restful-api-guidelines/#133)
    - [**SHOULD** use kebab-case with uppercase separate words for HTTP headers](https://opensource.zalando.com/restful-api-guidelines/#132)
    - [**MUST** use **`Content-*`** headers correctly](https://opensource.zalando.com/restful-api-guidelines/#178)
    - [**SHOULD** use **`Location`** header instead of **`Content-Location`** header](https://opensource.zalando.com/restful-api-guidelines/#180)
    - [**MAY** use **`Content-Location`** header](https://opensource.zalando.com/restful-api-guidelines/#179)
    - [**MAY** consider to support **`Prefer`** header to handle processing preferences](https://opensource.zalando.com/restful-api-guidelines/#181)
    - [**MAY** consider to support **`ETag`** together with **`If-Match`**/**`If-None-Match`** header](https://opensource.zalando.com/restful-api-guidelines/#182)
    - [**MAY** consider to support **`Idempotency-Key`** header](https://opensource.zalando.com/restful-api-guidelines/#230)
    - [**SHOULD** use only the specified proprietary Zalando headers](https://opensource.zalando.com/restful-api-guidelines/#183)
    - [**MUST** propagate proprietary headers](https://opensource.zalando.com/restful-api-guidelines/#184)
    - [**MUST** support **`X-Flow-ID`**](https://opensource.zalando.com/restful-api-guidelines/#233)
- [12. REST Design - Hypermedia](https://opensource.zalando.com/restful-api-guidelines/#hypermedia)
    - [**MUST** use REST maturity level 2](https://opensource.zalando.com/restful-api-guidelines/#162)
    - [**MAY** use REST maturity level 3 - HATEOAS](https://opensource.zalando.com/restful-api-guidelines/#163)
    - [**MUST** use common hypertext controls](https://opensource.zalando.com/restful-api-guidelines/#164)
    - [**SHOULD** use simple hypertext controls for pagination and self-references](https://opensource.zalando.com/restful-api-guidelines/#165)
    - [**MUST** use full, absolute URI for resource identification](https://opensource.zalando.com/restful-api-guidelines/#217)
    - [**MUST** not use link headers with JSON entities](https://opensource.zalando.com/restful-api-guidelines/#166)
- [13. REST Design - Performance](https://opensource.zalando.com/restful-api-guidelines/#performance)
    - [**SHOULD** reduce bandwidth needs and improve responsiveness](https://opensource.zalando.com/restful-api-guidelines/#155)
    - [**SHOULD** use **`gzip`** compression](https://opensource.zalando.com/restful-api-guidelines/#156)
    - [**SHOULD** support partial responses via filtering](https://opensource.zalando.com/restful-api-guidelines/#157)
    - [**SHOULD** allow optional embedding of sub-resources](https://opensource.zalando.com/restful-api-guidelines/#158)
    - [**MUST** document cacheable **`GET`**, **`HEAD`**, and **`POST`** endpoints](https://opensource.zalando.com/restful-api-guidelines/#227)
- [14. REST Design - Pagination](https://opensource.zalando.com/restful-api-guidelines/#pagination)
    - [**MUST** support pagination](https://opensource.zalando.com/restful-api-guidelines/#159)
    - [**SHOULD** prefer cursor-based pagination, avoid offset-based pagination](https://opensource.zalando.com/restful-api-guidelines/#160)
    - [**SHOULD** use pagination response page object](https://opensource.zalando.com/restful-api-guidelines/#248)
    - [**SHOULD** use pagination links](https://opensource.zalando.com/restful-api-guidelines/#161)
    - [**SHOULD** avoid a total result count](https://opensource.zalando.com/restful-api-guidelines/#254)
- [15. REST Design - Compatibility](https://opensource.zalando.com/restful-api-guidelines/#compatibility)
    - [**MUST** not break backward compatibility](https://opensource.zalando.com/restful-api-guidelines/#106)
    - [**SHOULD** prefer compatible extensions](https://opensource.zalando.com/restful-api-guidelines/#107)
    - [**SHOULD** design APIs conservatively](https://opensource.zalando.com/restful-api-guidelines/#109)
    - [**MUST** prepare clients to accept compatible API extensions](https://opensource.zalando.com/restful-api-guidelines/#108)
    - [**MUST** treat OpenAPI specification as open for extension by default](https://opensource.zalando.com/restful-api-guidelines/#111)
    - [**SHOULD** avoid versioning](https://opensource.zalando.com/restful-api-guidelines/#113)
    - [**MUST** use media type versioning](https://opensource.zalando.com/restful-api-guidelines/#114)
    - [**MUST** not use URL versioning](https://opensource.zalando.com/restful-api-guidelines/#115)
    - [**MUST** always return JSON objects as top-level data structures](https://opensource.zalando.com/restful-api-guidelines/#110)
    - [**SHOULD** use open-ended list of values (**`x-extensible-enum`**) for enumeration types](https://opensource.zalando.com/restful-api-guidelines/#112)
- [16. REST Design - Deprecation](https://opensource.zalando.com/restful-api-guidelines/#deprecation)
    - [**MUST** reflect deprecation in API specifications](https://opensource.zalando.com/restful-api-guidelines/#187)
    - [**MUST** obtain approval of clients before API shut down](https://opensource.zalando.com/restful-api-guidelines/#185)
    - [**MUST** collect external partner consent on deprecation time span](https://opensource.zalando.com/restful-api-guidelines/#186)
    - [**MUST** monitor usage of deprecated API scheduled for sunset](https://opensource.zalando.com/restful-api-guidelines/#188)
    - [**SHOULD** add **`Deprecation`** and **`Sunset`** header to responses](https://opensource.zalando.com/restful-api-guidelines/#189)
    - [**SHOULD** add monitoring for **`Deprecation`** and **`Sunset`** header](https://opensource.zalando.com/restful-api-guidelines/#190)
    - [**MUST** not start using deprecated APIs](https://opensource.zalando.com/restful-api-guidelines/#191)
- [17. REST Operation](https://opensource.zalando.com/restful-api-guidelines/#api-operation)
    - [**MUST** publish OpenAPI specification for non-component-internal APIs](https://opensource.zalando.com/restful-api-guidelines/#192)
    - [**SHOULD** monitor API usage](https://opensource.zalando.com/restful-api-guidelines/#193)
- [18. EVENT Basics - Event Types](https://opensource.zalando.com/restful-api-guidelines/#events)
    - [**MUST** define events compliant with overall API guidelines](https://opensource.zalando.com/restful-api-guidelines/#208)
    - [**MUST** treat events as part of the service interface](https://opensource.zalando.com/restful-api-guidelines/#194)
    - [**MUST** make event schema available for review](https://opensource.zalando.com/restful-api-guidelines/#195)
    - [**MUST** specify and register events as event types](https://opensource.zalando.com/restful-api-guidelines/#197)
    - [**MUST** follow naming convention for event type names](https://opensource.zalando.com/restful-api-guidelines/#213)
    - [**MUST** indicate ownership of event types](https://opensource.zalando.com/restful-api-guidelines/#207)
    - [**MUST** carefully define the compatibility mode](https://opensource.zalando.com/restful-api-guidelines/#245)
    - [**MUST** ensure event schema conforms to OpenAPI schema object](https://opensource.zalando.com/restful-api-guidelines/#196)
    - [**SHOULD** avoid **`additionalProperties`** in event type schemas](https://opensource.zalando.com/restful-api-guidelines/#210)
    - [**MUST** use semantic versioning of event type schemas](https://opensource.zalando.com/restful-api-guidelines/#246)
- [19. EVENT Basics - Event Categories](https://opensource.zalando.com/restful-api-guidelines/#event-categories)
    - [**MUST** ensure that events conform to an event category](https://opensource.zalando.com/restful-api-guidelines/#198)
    - [**MUST** provide mandatory event metadata](https://opensource.zalando.com/restful-api-guidelines/#247)
    - [**MUST** provide unique event identifiers](https://opensource.zalando.com/restful-api-guidelines/#211)
    - [**MUST** use general events to signal steps in business processes](https://opensource.zalando.com/restful-api-guidelines/#201)
    - [**SHOULD** provide explicit event ordering for general events](https://opensource.zalando.com/restful-api-guidelines/#203)
    - [**MUST** use data change events to signal mutations](https://opensource.zalando.com/restful-api-guidelines/#202)
    - [**MUST** provide explicit event ordering for data change events](https://opensource.zalando.com/restful-api-guidelines/#242)
    - [**SHOULD** use the hash partition strategy for data change events](https://opensource.zalando.com/restful-api-guidelines/#204)
- [20. EVENT Design](https://opensource.zalando.com/restful-api-guidelines/#events-design)
    - [**SHOULD** avoid writing sensitive data to events](https://opensource.zalando.com/restful-api-guidelines/#200)
    - [**MUST** be robust against duplicates when consuming events](https://opensource.zalando.com/restful-api-guidelines/#214)
    - [**SHOULD** design for idempotent out-of-order processing](https://opensource.zalando.com/restful-api-guidelines/#212)
    - [**MUST** ensure that events define useful business resources](https://opensource.zalando.com/restful-api-guidelines/#199)
    - [**SHOULD** ensure that data change events match the APIs resources](https://opensource.zalando.com/restful-api-guidelines/#205)
    - [**MUST** maintain backwards compatibility for events](https://opensource.zalando.com/restful-api-guidelines/#209)

## 1. Create the Controller

- **MUST** follow API first principle
- **MUST** use U.S. English
- **MUST** implement security as per guidelines
- **MUST** use the method constraints to define the constraints
- **MUST** have the http verb in controller name
- **MUST** add validation constraints if needed
- Instead of PATCH verb use PUT
- If the method is POST or PUT the response must be empty
    - if creating response code MUST be 201
    - if updating response code MUST be 200
- If the use case is for updating MUST use Updater like suffix
- If the use case is for creating MUST use Creator like suffix
- If the use case is for finding MUST use Finder like suffix
- If the use case is for searching MUST use Searcher like suffix

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingAccounts;

use Exception;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcher;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcherRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization\AccountingAccountsPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/accounting/accounting-accounts",
 *     summary="Search accounting accounts based on filters",
 *     tags={"Backoffice - Accounting - Accounting Accounts"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         required=true,
 *         description="The tenant ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number for pagination",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             minimum=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of accounting accounts list",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="string", example="123e4567-e89b-12d3-a456-426655440000"),
 *                     @OA\Property(property="code", type="string", example="101"),
 *                     @OA\Property(property="name", type="string", example="Cash Account"),
 *                     @OA\Property(property="description", type="string", example="Main cash account", nullable=true),
 *                     @OA\Property(property="type", type="integer", example=1, description="1 = asset, 2 = liability, 3 = equity, 4 = revenue, 5 = expense"),
 *                     @OA\Property(property="status", type="string", example="ACTIVE", description="Account status"),
 *                     @OA\Property(property="parent_id", type="string", example="123e4567-e89b-12d3-a456-426655440001", nullable=true),
 *                     @OA\Property(property="creator_id", type="integer", example=1),
 *                     @OA\Property(property="updater_id", type="integer", example=1),
 *                     @OA\Property(property="company_id", type="string", example="company-123")
 *                 )
 *             ),
 *             @OA\Property(property="total", type="integer", example=100),
 *             @OA\Property(property="per_page", type="integer", example=10),
 *             @OA\Property(property="current_page", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to view this resource.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */
final class AccountingAccountsGetController
{
    public function __construct(
        private readonly AccountingAccountsSearcher $searcher
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(AccountingAccountsPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $filters = (array)$request->query();
            $filters["company_id"] = $request->user()->id;

            $searcherRequest = new AccountingAccountsSearcherRequest($filters);
            $searcherResponse = ($this->searcher)($searcherRequest);

            $users = array_map(function ($user) {
                return [
                    "id" => $user->id(),
                    "code" => $user->code(),
                    "name" => $user->name(),
                    "description" => $user->description(),
                    "type" => $user->type(),
                    "status" => $user->status(),
                    "parent_id" => $user->parentId(),
                    "creator_id" => $user->creatorId(),
                    "updater_id" => $user->updaterId(),
                    "company_id" => $user->companyId()
                ];
            }, $searcherResponse->items());

            return response()->json([
                "items" => $users,
                "total" => $searcherResponse->total(),
                "per_page" => $searcherResponse->perPage(),
                "current_page" => $searcherResponse->currentPage()
            ]);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "status" => JsonResponse::HTTP_FORBIDDEN,
                "detail" => "You do not have permission to view this resource.",
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            $detail = config('app.env') !== 'production' ? $e->getMessage() : "An unexpected error occurred";
            return response()->json([
                "title" => "Internal Server Error",
                "status" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                "detail" => $detail,
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
```

## 2. Create the Route File

- **MUST** use Kebab case for filename

```php
// routes/backoffice/accounting/accounting-accounts/accounting-accounts.php
Route::get('/accounting-accounts', AccountingAccountsGetController::class)
    ->name('accounting-accounts.search');
```

## 3. Create the HTTP Request File

- **MUST** use Kebab case for filename

```http
# etc/http/backoffice/accounting/accounting-accounts/accounting-accounts-GET.http
GET http://localhost/api/backoffice/{{tenant}}/accounting/accounting-accounts
accept: application/json
Authorization: Bearer {{token}}
```

## 4. Create Unit Testing

### Test

```php
<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Application\Search;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcher;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcherRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AccountingAccountsSearcherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_accounting_accounts(): void
    {
        $accountingAccount = AccountingAccountMother::create();
        $filters = ["id" => $accountingAccount->id(),];

        $accountingAccountRepository = $this->mock(AccountingAccountRepository::class);
        $accountingAccountRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                "items" => [$accountingAccount],
                "total" => 1,
                "perPage" => 10,
                "currentPage" => 1,
            ]);

        /** @var AccountingAccountRepository $accountingAccountRepository */
        $searcher = new AccountingAccountsSearcher($accountingAccountRepository);
        ($searcher)(new AccountingAccountsSearcherRequest($filters));
    }
}
```

### Object Mother

```php
<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountStatus;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountType;

final class AccountingAccountMother
{
    public static function create(
        ?string $id = null,
        ?string $code = null,
        ?string $name = null,
        ?string $description = null,
        ?int $type = null,
        ?string $status = null,
        ?string $parentId = null,
        ?int $creatorId = null,
        ?int $updaterId = null,
        ?string $companyId = null
    ): AccountingAccount
    {
        $faker = Factory::create();

        $userId = $faker->numberBetween(1, 100);

        return new AccountingAccount(
            $id ?? $faker->uuid(),
                $code ?? $faker->uuid(),
            $name ?? $faker->name(),
            $description ?? $faker->text(),
            $type ?? $faker->randomElement([
                AccountingAccountType::ASSET,
                AccountingAccountType::LIABILITY,
                AccountingAccountType::EQUITY,
                AccountingAccountType::REVENUE,
                AccountingAccountType::EXPENSE
            ]),
                $status ?? $faker->randomElement([
                    AccountingAccountStatus::ACTIVE,
                    AccountingAccountStatus::INACTIVE
                ]),
            $parentId ?? $faker->uuid(),
                $creatorId ?? $userId,
                $updaterId ?? $userId,
            $companyId ?? $faker->uuid()

        );
    }
}
```

## 5. Create Use Case

### Use case

- **MUST** return void when is a creator, updater or deleter.

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use function Lambdish\Phunctional\map;

class AccountingAccountsSearcher
{
    public function __construct(
        private readonly AccountingAccountRepository $repository
    )
    {
    }

    public function __invoke(AccountingAccountsSearcherRequest $request): AccountingAccountsSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new AccountingAccountsSearcherResponse(
            map(function (AccountingAccount $accountingAccount) {
                return new AccountingAccountSearcherResponse(
                    $accountingAccount->id(),
                    $accountingAccount->code(),
                    $accountingAccount->name(),
                    $accountingAccount->description(),
                    $accountingAccount->type(),
                    $accountingAccount->status(),
                    $accountingAccount->parentId(),
                    $accountingAccount->creatorId(),
                    $accountingAccount->updaterId(),
                    $accountingAccount->companyId()
                );
            }, $result["items"]),
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
```

### Request

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search;

final class AccountingAccountsSearcherRequest
{
    private array $filters;

    public function __construct(
        array $filters,
    )
    {
        $this->filters = $filters;
    }

    public function filters(): array
    {
        return $this->filters;
    }
}
```

### Response

- **MUST** no exists is a creator, updater or deleter.

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search;

final readonly class AccountingAccountSearcherResponse
{
    public function __construct(
        private string $id,
        private string $code,
        private string $name,
        private ?string $description,
        private int $type,
        private string $status,
        private ?string $parentId,
        private int $creatorId,
        private int $updaterId,
        private string $companyId
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function parentId(): ?string
    {
        return $this->parentId;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function updaterId(): int
    {
        return $this->updaterId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
```

### Aggregate

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AccountingAccount extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private string $code,
        private string $name,
        private ?string $description,
        private int $type,
        private string $status,
        private ?string $parentId,
        private int $creatorId,
        private int $updaterId,
        private string $companyId
    ) {
    }

    public static function create(
        string $id,
        string $code,
        string $name,
        ?string $description,
        int $type,
        ?string $parentId,
        int $creatorId,
        string $companyId
    ): self
    {

        $status = AccountingAccountStatus::ACTIVE;
        $updaterId = $creatorId;

        $accountingAccount = new self(
            $id,
            $code,
            $name,
            $description,
            $type,
            $status,
            $parentId,
            $creatorId,
            $updaterId,
            $companyId
        );

        $accountingAccount->record(new AccountingAccountCreatedDomainEvent(
            $accountingAccount->id(),
            $accountingAccount->code(),
            $accountingAccount->name(),
            $accountingAccount->description(),
            $accountingAccount->type(),
            $accountingAccount->status(),
            $accountingAccount->parentId(),
            $accountingAccount->creatorId(),
            $accountingAccount->updaterId(),
            $accountingAccount->companyId()
        ));

        return $accountingAccount;
    }

    public static function fromPrimitives(array $row): self
    {

        return new self(
            (string)$row['id'],
            (string)$row['code'],
            (string)$row['name'],
            (string)($row['description'] ?? null),
            (int)$row['type'],
            (string)$row['status'],
            (string)($row['parent_id'] ?? null),
            (int)$row['creator_id'],
            (int)$row['updater_id'],
            (string)$row['company_id']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'code' => $this->code(),
            'name' => $this->name(),
            'description' => $this->description(),
            'type' => $this->type(),
            'status' => $this->status(),
            'parentId' => $this->parentId(),
            'creatorId' => $this->creatorId(),
            'updaterId' => $this->updaterId(),
            'companyId' => $this->companyId()
        ];
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function parentId(): ?string
    {
        return $this->parentId;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function updaterId(): int
    {
        return $this->updaterId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function changeName(string $name): void
    {
        if ($name === $this->name()) {
            return;
        }

        $this->name = $name;
    }

    public function changeDescription(?string $description): void
    {
        if ($description === $this->description()) {
            return;
        }

        $this->description = $description;
    }

    public function changeType(int $type): void
    {
        if ($type === $this->type()) {
            return;
        }

        $this->type = $type;
    }

    public function changeStatus(string $status): void
    {
        if ($status === $this->status()) {
            return;
        }

        $this->status = $status;
    }

    public function changeUpdaterId(int $updaterId): void
    {
        if ($updaterId === $this->updaterId()) {
            return;
        }

        $this->updaterId = $updaterId;
    }

    public function changeParentId(?string $parentId): void
    {
        if ($parentId === $this->parentId()) {
            return;
        }

        $this->parentId = $parentId;
    }
}
```

### Exception

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use DomainException;

final class AccountingAccountNotFound extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("The accounting account with id <$id> does not exist.");
    }
}
```

### Value Object - AccountingAccountType

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use InvalidArgumentException;

class AccountingAccountType
{
    public const ASSET = 1;
    public const LIABILITY = 2;
    public const EQUITY = 3;
    public const REVENUE = 4;
    public const EXPENSE = 5;

    private static array $typeName = [
        self::ASSET => 'Activo',
        self::LIABILITY => 'Pasivo',
        self::EQUITY => 'Patrimonio',
        self::REVENUE => 'Ingreso',
        self::EXPENSE => 'Gasto',
    ];

    private readonly int $value;

    public function __construct(int $value)
    {
        $this->ensureIsValidType($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function ensureIsValidType(int $value): void
    {
        if (!in_array($value, [
            self::ASSET,
            self::LIABILITY,
            self::EQUITY,
            self::REVENUE,
            self::EXPENSE
        ])) {
            throw new InvalidArgumentException(sprintf('The type <%s> is invalid', $value));
        }
    }

    public function typeName(): int
    {
        return self::$typeName[$this->value] ?? self::EXPENSE;
    }
}
```

### Value Object - AccountingAccountStatus

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use InvalidArgumentException;

class AccountingAccountStatus
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    private static array $statusName = [
        self::ACTIVE => 'Activo',
        self::INACTIVE => 'Inactivo',
    ];

    private readonly string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidStatus($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function ensureIsValidStatus(string $value): void
    {
        if (!in_array($value, [
            self::ACTIVE,
            self::INACTIVE
        ])) {
            throw new InvalidArgumentException(sprintf('The status <%s> is invalid', $value));
        }
    }

    public function isEqual(AccountingAccountStatus $status): bool
    {
        return $this->value === $status->value();
    }

    public function statusName(): string
    {
        return self::$statusName[$this->value] ?? self::INACTIVE;
    }
}
```

### Repository

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

interface AccountingAccountRepository
{
    public function save(AccountingAccount $accountingAccount): void;

    public function find(string $id): ?AccountingAccount;

    public function search(array $filters): array;
}
```

### Repository Implementation

```php
<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use Closure;
use Exception;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use RuntimeException;
use function Lambdish\Phunctional\map;


final class EloquentAccountingAccountRepository implements AccountingAccountRepository
{
    public function save(AccountingAccount $accountingAccount): void
    {
        try {
            $data = [
                'id' => $accountingAccount->id(),
                'code' => $accountingAccount->code(),
                'name' => $accountingAccount->name(),
                'description' => $accountingAccount->description(),
                'type' => $accountingAccount->type(),
                'status' => $accountingAccount->status(),
                'parent_id' => $accountingAccount->parentId(),
                'creator_id' => $accountingAccount->creatorId(),
                'updater_id' => $accountingAccount->updaterId(),
                'company_id' => $accountingAccount->companyId()
            ];

            AccountingAccountModel::updateOrCreate(
                ['id' => $accountingAccount->id()],
                $data
            );

        } catch (Exception $e) {
            throw new RuntimeException("Failed to save accounting account: " . $e->getMessage(), 0, $e);
        }
    }

    public function find(string $id): ?AccountingAccount
    {
        $model = AccountingAccountModel::find($id);

        if (!$model) {
            return null;
        }

        $AccountingAccountData = $model->toArray();
        $AccountingAccountData['password'] = $model->password;

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($AccountingAccountData);
    }

    public function search(array $filters, int $perPage = 20): array
    {
        $paginator = AccountingAccountModel::fromFilters($filters)
            ->paginate($perPage);

        return [
            'items' => map($this->fromDatabase(), $paginator->items()),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    }

    private function fromDatabase(): Closure
    {
        return fn(AccountingAccountModel $model) => AccountingAccount::fromPrimitives([
            'id' => $model['id'],
            'code' => $model['code'],
            'name' => $model['name'],
            'description' => $model['description'],
            'type' => $model['type'],
            'status' => $model['status'],
            'parent_id' => $model['parent_id'],
            'creator_id' => $model['creator_id'],
            'updater_id' => $model['updater_id'],
            'company_id' => $model['company_id']
        ]);
    }
}
```

### Permissions

```php
<?php

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization;

enum AccountingAccountsPermissions: string
{
    case CREATE = 'backoffice.accounting.accounting-accounts.created';
    case UPDATE = 'backoffice.accounting.accounting-accounts.updated';
    case VIEW = 'backoffice.accounting.accounting-accounts.view';

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create Accounting Account',
            self::UPDATE => 'Update Accounting Account',
            self::VIEW => 'View Accounting Account',
        };
    }
}
```
