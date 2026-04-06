# 🏥 Hospital Washroom Management System (WMS)

A high-fidelity facility management system and professional tracking dashboard built for intensive hospital environments.

---

## 🛠️ Step-by-Step MySQL Setup Guide (XAMPP)

Follow these exact steps to connect your system to a local MySQL instance.

### Step 1: Start XAMPP
1. Open **XAMPP Control Panel**.
2. Start **Apache** and **MySQL** (Ensure both show a **Green** status).

### Step 2: Database Initialization
1. Visit `http://localhost/phpmyadmin`.
2. Create a **New** database named: `wms_db`.
3. Use collation: `utf8mb4_general_ci`.

### Step 3: Deployment & Seeding
1. Open your terminal in the project root.
2. Execute the deployment sequence:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *This builds the tables and registers the Root Admin account.*

---

## 📊 Database Relational Mapping (Full View)

The application utilizes a relational MySQL schema for high operational integrity.

| Table | High-Level Description | Key Columns |
| :--- | :--- | :--- |
| **`users`** | Personnel Registry | `id`, `name`, `email`, `role` (admin/staff/user), `password`, `must_change_password`, `last_login`, `email_verified_at` |
| **`floors`** | Hospital Levels | `id`, `name`, `level` (e.g., -1 for Basement, 0 for ground) |
| **`rooms`** | Facility Units | `id`, `floor_id`, `room_number`, `type` (general/private), `status` |
| **`washrooms`** | Asset Tracking | `id`, `floor_id`, `room_id` (null if public), `room_number`, `type` (public/attached), `status` |
| **`tasks`** | Operational Log | `id`, `floor_id`, `washroom_id`, `assigned_to` (staff ID), `status` (assigned/in_progress/completed), `completed_at` |
| **`complaints`** | Intelligence Uplink | `id`, `user_id`, `floor_id`, `washroom_id`, `complaint_type`, `description`, `image_path`, `status` |

---

## 🔐 Authentication Protocols

We implement a tiered security model for different operative roles:

### 1. Root Administration
*   **Initial Credential**: `admin@wms.com` / `password123`.
*   **Action**: Admin logs in to the dashboard to deploy infrastructure (floors/rooms) and onboard personnel.
*   **Update**: Admin can update their identity and security credentials through the **Strategic Profile** settings.

### 2. Operational Staff (Operatives)
*   **Onboarding**: Staff accounts are **NOT** seeded. They are created manually by the Admin.
*   **Credentials**: The system generates a temporary password and **emails the credentials** to the operative's uplink.
*   **Security**: Staff are required to change their password on first login via a mandatory security redirect.

### 3. Public Users
*   **Registration**: Users register their own accounts through the **Public Registration Portal**.
*   **Role**: Limited access; focused on reporting maintenance issues and tracking complaint status.

---

## 🗃️ Persistent Synchronization
*   All data—including password changes, profile updates, and maintenance task logs—is **instantly persisted** to the MySQL database.
*   **Note**: The development `database.sqlite` file is redundant and should be removed from production to avoid synchronization conflicts.

---

Developed for **INT221-MVC Programming** (Unit VI).
