# Library Management API

This API provides the ability to manage a library system, including features for user authentication, book management, borrowing, and reporting. It is built using Laravel and utilizes JWT for authentication.

## Base URL

The base URL for the API is:  
[https://library-management-86s2.onrender.com](https://library-management-86s2.onrender.com)

## Authentication

### User Registration

**Endpoint**: `POST /api/register`  
**Description**: Register a new user.  
**Body Parameters**:
- `name`: User's name (string)
- `email`: User's email (string)
- `password`: User's password (string)

```bash
POST /api/register
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password123"
}
