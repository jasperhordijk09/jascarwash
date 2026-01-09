# V1Api

All URIs are relative to *http://127.0.0.1:8000/api*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**getNumberplateV1NumberplateNumberplateGet**](V1Api.md#getnumberplatev1numberplatenumberplateget) | **GET** /v1/numberplate/{numberplate} | Get Numberplate |
| [**getSortTypesV1Get**](V1Api.md#getsorttypesv1get) | **GET** /v1/ | Get Sorttypes |
| [**getSortTypesV1Get_0**](V1Api.md#getsorttypesv1get_0) | **GET** /v1 | Get Sorttypes |
| [**needAdminV1NeedAdminGet**](V1Api.md#needadminv1needadminget) | **GET** /v1/needAdmin | Needadmin |
| [**needAuthV1NeedAuthGet**](V1Api.md#needauthv1needauthget) | **GET** /v1/needAuth | Needauth |



## getNumberplateV1NumberplateNumberplateGet

> Array&lt;NumberplateData&gt; getNumberplateV1NumberplateNumberplateGet(numberplate)

Get Numberplate

### Example

```ts
import {
  Configuration,
  V1Api,
} from '';
import type { GetNumberplateV1NumberplateNumberplateGetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new V1Api();

  const body = {
    // string
    numberplate: numberplate_example,
  } satisfies GetNumberplateV1NumberplateNumberplateGetRequest;

  try {
    const data = await api.getNumberplateV1NumberplateNumberplateGet(body);
    console.log(data);
  } catch (error) {
    console.error(error);
  }
}

// Run the test
example().catch(console.error);
```

### Parameters


| Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **numberplate** | `string` |  | [Defaults to `undefined`] |

### Return type

[**Array&lt;NumberplateData&gt;**](NumberplateData.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
| **200** | Successful Response |  -  |
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## getSortTypesV1Get

> any getSortTypesV1Get()

Get Sorttypes

### Example

```ts
import {
  Configuration,
  V1Api,
} from '';
import type { GetSortTypesV1GetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new V1Api();

  try {
    const data = await api.getSortTypesV1Get();
    console.log(data);
  } catch (error) {
    console.error(error);
  }
}

// Run the test
example().catch(console.error);
```

### Parameters

This endpoint does not need any parameter.

### Return type

**any**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
| **200** | Successful Response |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## getSortTypesV1Get_0

> any getSortTypesV1Get_0()

Get Sorttypes

### Example

```ts
import {
  Configuration,
  V1Api,
} from '';
import type { GetSortTypesV1Get0Request } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new V1Api();

  try {
    const data = await api.getSortTypesV1Get_0();
    console.log(data);
  } catch (error) {
    console.error(error);
  }
}

// Run the test
example().catch(console.error);
```

### Parameters

This endpoint does not need any parameter.

### Return type

**any**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
| **200** | Successful Response |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## needAdminV1NeedAdminGet

> any needAdminV1NeedAdminGet()

Needadmin

### Example

```ts
import {
  Configuration,
  V1Api,
} from '';
import type { NeedAdminV1NeedAdminGetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new V1Api();

  try {
    const data = await api.needAdminV1NeedAdminGet();
    console.log(data);
  } catch (error) {
    console.error(error);
  }
}

// Run the test
example().catch(console.error);
```

### Parameters

This endpoint does not need any parameter.

### Return type

**any**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
| **200** | Successful Response |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## needAuthV1NeedAuthGet

> any needAuthV1NeedAuthGet()

Needauth

### Example

```ts
import {
  Configuration,
  V1Api,
} from '';
import type { NeedAuthV1NeedAuthGetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new V1Api();

  try {
    const data = await api.needAuthV1NeedAuthGet();
    console.log(data);
  } catch (error) {
    console.error(error);
  }
}

// Run the test
example().catch(console.error);
```

### Parameters

This endpoint does not need any parameter.

### Return type

**any**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
| **200** | Successful Response |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)

