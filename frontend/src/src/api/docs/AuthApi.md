# AuthApi

All URIs are relative to *http://127.0.0.1:8000/api*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**changePasswordAuthChangePasswordPost**](AuthApi.md#changepasswordauthchangepasswordpost) | **POST** /auth/change-password | Change Password |
| [**changePermissionsAuthChangePermissionsPost**](AuthApi.md#changepermissionsauthchangepermissionspost) | **POST** /auth/change-permissions | Change Permissions |
| [**disableUserAuthDisableUserPost**](AuthApi.md#disableuserauthdisableuserpost) | **POST** /auth/disable-user | Disable User |
| [**enableUserAuthEnableUserPost**](AuthApi.md#enableuserauthenableuserpost) | **POST** /auth/enable-user | Enable User |
| [**generateHashAuthGenerateHashPost**](AuthApi.md#generatehashauthgeneratehashpost) | **POST** /auth/generate-hash | Generate Hash |
| [**getUserInfoAuthUserUsernameGet**](AuthApi.md#getuserinfoauthuserusernameget) | **GET** /auth/user/{username} | Get User Info |
| [**listUsersAuthListUsersGet**](AuthApi.md#listusersauthlistusersget) | **GET** /auth/list-users | List Users |
| [**loginForAccessTokenAuthLoginPost**](AuthApi.md#loginforaccesstokenauthloginpost) | **POST** /auth/login | Login For Access Token |
| [**logoutAuthLogoutPost**](AuthApi.md#logoutauthlogoutpost) | **POST** /auth/logout | Logout |
| [**registerUserAuthRegisterPost**](AuthApi.md#registeruserauthregisterpost) | **POST** /auth/register | Register User |
| [**whoIsCurrentUserAuthWhoamiGet**](AuthApi.md#whoiscurrentuserauthwhoamiget) | **GET** /auth/whoami | Who Is Current User |



## changePasswordAuthChangePasswordPost

> any changePasswordAuthChangePasswordPost(password, username)

Change Password

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { ChangePasswordAuthChangePasswordPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    password: password_example,
    // string (optional)
    username: username_example,
  } satisfies ChangePasswordAuthChangePasswordPostRequest;

  try {
    const data = await api.changePasswordAuthChangePasswordPost(body);
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
| **password** | `string` |  | [Defaults to `undefined`] |
| **username** | `string` |  | [Optional] [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## changePermissionsAuthChangePermissionsPost

> any changePermissionsAuthChangePermissionsPost(username, permissions)

Change Permissions

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { ChangePermissionsAuthChangePermissionsPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    username: username_example,
    // number
    permissions: 56,
  } satisfies ChangePermissionsAuthChangePermissionsPostRequest;

  try {
    const data = await api.changePermissionsAuthChangePermissionsPost(body);
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
| **username** | `string` |  | [Defaults to `undefined`] |
| **permissions** | `number` |  | [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## disableUserAuthDisableUserPost

> any disableUserAuthDisableUserPost(username)

Disable User

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { DisableUserAuthDisableUserPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    username: username_example,
  } satisfies DisableUserAuthDisableUserPostRequest;

  try {
    const data = await api.disableUserAuthDisableUserPost(body);
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
| **username** | `string` |  | [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## enableUserAuthEnableUserPost

> any enableUserAuthEnableUserPost(username)

Enable User

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { EnableUserAuthEnableUserPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    username: username_example,
  } satisfies EnableUserAuthEnableUserPostRequest;

  try {
    const data = await api.enableUserAuthEnableUserPost(body);
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
| **username** | `string` |  | [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## generateHashAuthGenerateHashPost

> PasswordHashReturn generateHashAuthGenerateHashPost(password)

Generate Hash

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { GenerateHashAuthGenerateHashPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // any
    password: ...,
  } satisfies GenerateHashAuthGenerateHashPostRequest;

  try {
    const data = await api.generateHashAuthGenerateHashPost(body);
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
| **password** | `any` |  | [Defaults to `undefined`] |

### Return type

[**PasswordHashReturn**](PasswordHashReturn.md)

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


## getUserInfoAuthUserUsernameGet

> any getUserInfoAuthUserUsernameGet(username)

Get User Info

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { GetUserInfoAuthUserUsernameGetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    username: username_example,
  } satisfies GetUserInfoAuthUserUsernameGetRequest;

  try {
    const data = await api.getUserInfoAuthUserUsernameGet(body);
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
| **username** | `string` |  | [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## listUsersAuthListUsersGet

> Array&lt;User&gt; listUsersAuthListUsersGet()

List Users

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { ListUsersAuthListUsersGetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  try {
    const data = await api.listUsersAuthListUsersGet();
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

[**Array&lt;User&gt;**](User.md)

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


## loginForAccessTokenAuthLoginPost

> any loginForAccessTokenAuthLoginPost(username, password)

Login For Access Token

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { LoginForAccessTokenAuthLoginPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    username: username_example,
    // string
    password: password_example,
  } satisfies LoginForAccessTokenAuthLoginPostRequest;

  try {
    const data = await api.loginForAccessTokenAuthLoginPost(body);
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
| **username** | `string` |  | [Defaults to `undefined`] |
| **password** | `string` |  | [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## logoutAuthLogoutPost

> LogoutReturn logoutAuthLogoutPost()

Logout

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { LogoutAuthLogoutPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  try {
    const data = await api.logoutAuthLogoutPost();
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

[**LogoutReturn**](LogoutReturn.md)

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


## registerUserAuthRegisterPost

> any registerUserAuthRegisterPost(username, password, fullName, email)

Register User

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { RegisterUserAuthRegisterPostRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  const body = {
    // string
    username: username_example,
    // string
    password: password_example,
    // string (optional)
    fullName: fullName_example,
    // string (optional)
    email: email_example,
  } satisfies RegisterUserAuthRegisterPostRequest;

  try {
    const data = await api.registerUserAuthRegisterPost(body);
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
| **username** | `string` |  | [Defaults to `undefined`] |
| **password** | `string` |  | [Defaults to `undefined`] |
| **fullName** | `string` |  | [Optional] [Defaults to `undefined`] |
| **email** | `string` |  | [Optional] [Defaults to `undefined`] |

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
| **422** | Validation Error |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#api-endpoints) [[Back to Model list]](../README.md#models) [[Back to README]](../README.md)


## whoIsCurrentUserAuthWhoamiGet

> User whoIsCurrentUserAuthWhoamiGet()

Who Is Current User

### Example

```ts
import {
  Configuration,
  AuthApi,
} from '';
import type { WhoIsCurrentUserAuthWhoamiGetRequest } from '';

async function example() {
  console.log("🚀 Testing  SDK...");
  const api = new AuthApi();

  try {
    const data = await api.whoIsCurrentUserAuthWhoamiGet();
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

[**User**](User.md)

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

