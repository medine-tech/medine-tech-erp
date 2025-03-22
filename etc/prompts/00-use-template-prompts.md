# MedineTech's Aggregate Design Blueprint structure:

```markdown
Name: The name of the aggregate.
Description: A brief description of the aggregate.
Context: The context where the aggregate belongs.
Properties: A list of properties that the aggregate has. Optionally, you can specify the type of each property.
Enforced Invariants: A list of invariants that the aggregate enforces.
Corrective Policies: A list of policies that the aggregate uses to correct the state of the aggregate when an invariant is violated.
Domain Events: A list of events that the aggregate emits.
Ways to access: A list of ways to access the aggregate.
```

## User MedineTech Aggregate Design Blueprint:
```markdown
Name: Naive Bank Account
Description: An aggregate modeling in a very naive way a personal bank account. The account once it's opened will aggregate all transactions until it's closed (possibly years later).
Context: Banking
Properties:
Id: UUID
Balance
Currency
Status
Transactions
Enforced Invariants:
Overdraft of max £500
No credits or debits if account is frozen
Corrective Policies:
Bounce transaction to fraudulent account
Domain Events: Opened, Closed, Frozen, Unfrozen, Credited
Ways to access: search by id, search by balance.
```
