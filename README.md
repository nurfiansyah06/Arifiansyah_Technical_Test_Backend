# Technical Test: Lead Management System

## Overview

This project is designed to create a Lead Management System that accommodates different user roles and functionalities related to lead handling in a solar panel installation business. The system allows for the insertion and distribution of leads, status updates, and management of salesperson assignments and penalties.

## Table of Contents

1. [Database Structure](#database-structure)
2. [User Roles](#user-roles)
3. [API Endpoints](#api-endpoints)
4. [Features](#features)
5. [Installation](#installation)
6. [Usage](#usage)

## Database Structure

The database will include the following tables:

1. **users**
   - id (Primary Key)
   - name
   - email
   - password
   - role (Super Admin, Customer Service, Salesperson, Operational, Client)
   - residential_type (boolean)
   - commercial_type (boolean)
   - created_at
   - updated_at

2. **leads**
   - id (Primary Key)
   - title
   - client_id (Foreign Key to users)
   - salesperson_id (Foreign Key to users)
   - status (enum: New, Follow Up, Survey Request, Survey Approved, Survey Rejected, Survey Completed, Final Proposal, Deal)
   - notes (text)
   - image_path (string)
   - created_at
   - updated_at

3. **penalties**
   - id (Primary Key)
   - salesperson_id (Foreign Key to users)
   - start_time (datetime)
   - end_time (datetime)
   - is_exists (boolean)
   - created_at
   - updated_at

4. **status_updates**
   - id (Primary Key)
   - lead_id (Foreign Key to leads)
   - status (enum: New, Follow Up, Survey Request, Survey Approved, Survey Rejected, Survey Completed, Final Proposal, Deal)
   - notes (text)
   - image_path (string)
   - created_at
   - updated_at

## User Roles

1. **Super Admin**: Full access to the system, including user management and reporting.
2. **Customer Service**: Manage customer inquiries and lead assignments.
3. **Salesperson**: Handle leads, update statuses, and manage client interactions.
4. **Operational**: Approve or reject survey requests and handle operational tasks.
5. **Client**: View their leads and interact with salespersons.

## API Endpoints

### 1. Insert New Leads

- **Endpoint**: `POST /api/leads`
- **Description**: Insert a new lead and distribute it to a salesperson using Round Robin.
- **Request Body**:
    ```json
    {
        "title": "Lead Title",
        "client_id": 1
    }
    ```

### 2. Update Lead Status

- **Endpoint**: `PUT /api/leads/{id}/status`
- **Description**: Update the status of a lead.
- **Request Body**:
    ```json
    {
        "status": "Follow Up",
        "notes": "Notes regarding the lead",
        "image_path": "path/to/image.jpg"
    }
    ```

### 3. Transfer Lead Ownership

- **Endpoint**: `PATCH /api/leads/{id}/transfer`
- **Description**: Transfer the ownership of a lead to another salesperson.
- **Request Body**:
    ```json
    {
        "new_salesperson_id": 2
    }
    ```

### 4. Apply Penalties to Salesperson

- **Endpoint**: `POST /api/salespersons/{id}/penalties`
- **Description**: Apply a penalty to a salesperson, preventing them from receiving new leads during a specified time.
- **Request Body**:
    ```json
    {
        "start_time": "2024-10-01T10:00:00",
        "end_time": "2024-10-15T10:00:00"
    }
    ```

## Features

- Round Robin lead distribution among salespersons.
- Multi-status updates for leads.
- Ability to transfer lead ownership between salespersons.
- Implementation of penalties for salespersons with start and end times.
- Support for both Residential and Commercial sales types for each salesperson.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/lead-management-system.git
   cd lead-management-system
    ```
