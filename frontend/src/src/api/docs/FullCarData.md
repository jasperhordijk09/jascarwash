
# FullCarData


## Properties

Name | Type
------------ | -------------
`license_plate` | string
`make` | string
`model` | string
`vehicle_type` | string
`color` | string
`id` | string
`created_at` | Date
`notes` | string
`owner_id` | string

## Example

```typescript
import type { FullCarData } from ''

// TODO: Update the object below with actual values
const example = {
  "license_plate": null,
  "make": null,
  "model": null,
  "vehicle_type": null,
  "color": null,
  "id": null,
  "created_at": null,
  "notes": null,
  "owner_id": null,
} satisfies FullCarData

console.log(example)

// Convert the instance to a JSON string
const exampleJSON: string = JSON.stringify(example)
console.log(exampleJSON)

// Parse the JSON string back to an object
const exampleParsed = JSON.parse(exampleJSON) as FullCarData
console.log(exampleParsed)
```

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


