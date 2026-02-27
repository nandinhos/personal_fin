# 📦 Extensões Necessárias

```sql
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
```

---

# 👤 USERS

```sql
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    plan VARCHAR(20) DEFAULT 'free',
    api_key VARCHAR(255),
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL
);

CREATE INDEX idx_users_email ON users(email);
```

---

# 👥 PROFILES (Multi Perfil Financeiro)

```sql
CREATE TABLE profiles (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_id UUID NOT NULL,
    name VARCHAR(120) NOT NULL,
    currency VARCHAR(10) DEFAULT 'BRL',
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_profiles_user
        FOREIGN KEY(user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_profiles_user ON profiles(user_id);
```

---

# 🏦 ACCOUNTS

```sql
CREATE TABLE accounts (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    name VARCHAR(120) NOT NULL,
    bank_name VARCHAR(120),
    icon VARCHAR(255),
    balance NUMERIC(14,2) DEFAULT 0,
    color VARCHAR(20),
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_accounts_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_accounts_profile ON accounts(profile_id);
```

---

# 💳 CARDS

```sql
CREATE TABLE cards (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    name VARCHAR(120) NOT NULL,
    bank_name VARCHAR(120),
    icon VARCHAR(255),
    credit_limit NUMERIC(14,2) NOT NULL,
    closing_day INTEGER NOT NULL CHECK (closing_day BETWEEN 1 AND 31),
    due_day INTEGER NOT NULL CHECK (due_day BETWEEN 1 AND 31),
    status VARCHAR(20) DEFAULT 'open',
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_cards_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_cards_profile ON cards(profile_id);
```

---

# 📂 CATEGORIES

```sql
CREATE TABLE categories (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    name VARCHAR(120) NOT NULL,
    type VARCHAR(20) NOT NULL CHECK (type IN ('income','expense')),
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_categories_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_categories_profile ON categories(profile_id);
```

---

# 📁 SUBCATEGORIES

```sql
CREATE TABLE subcategories (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    category_id UUID NOT NULL,
    name VARCHAR(120) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_subcategories_category
        FOREIGN KEY(category_id)
        REFERENCES categories(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_subcategories_category ON subcategories(category_id);
```

---

# 💸 TRANSACTIONS

```sql
CREATE TABLE transactions (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    account_id UUID NULL,
    card_id UUID NULL,
    category_id UUID NOT NULL,
    subcategory_id UUID NULL,
    type VARCHAR(20) NOT NULL CHECK (type IN ('income','expense','transfer')),
    title VARCHAR(160) NOT NULL,
    description TEXT,
    amount NUMERIC(14,2) NOT NULL,
    transaction_date DATE NOT NULL,
    is_paid BOOLEAN DEFAULT true,
    recurrence VARCHAR(20) DEFAULT 'single',
    installment_group UUID NULL,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,

    CONSTRAINT fk_transactions_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_transactions_account
        FOREIGN KEY(account_id)
        REFERENCES accounts(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_transactions_card
        FOREIGN KEY(card_id)
        REFERENCES cards(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_transactions_category
        FOREIGN KEY(category_id)
        REFERENCES categories(id)
        ON DELETE RESTRICT
);
```

### Índices estratégicos para performance do dashboard:

```sql
CREATE INDEX idx_transactions_profile_date 
ON transactions(profile_id, transaction_date);

CREATE INDEX idx_transactions_account 
ON transactions(account_id);

CREATE INDEX idx_transactions_card 
ON transactions(card_id);

CREATE INDEX idx_transactions_category 
ON transactions(category_id);
```

---

# 🎯 GOALS (Metas)

```sql
CREATE TABLE goals (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    title VARCHAR(160) NOT NULL,
    image VARCHAR(255),
    target_amount NUMERIC(14,2) NOT NULL,
    current_amount NUMERIC(14,2) DEFAULT 0,
    target_date DATE,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_goals_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);
```

---

# 🚦 LIMITS (Limites por Categoria)

```sql
CREATE TABLE limits (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    category_id UUID NOT NULL,
    amount_limit NUMERIC(14,2) NOT NULL,
    recurrence VARCHAR(20) DEFAULT 'monthly',
    start_date DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_limits_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_limits_category
        FOREIGN KEY(category_id)
        REFERENCES categories(id)
        ON DELETE CASCADE
);
```

---

# 📈 INVESTMENTS

```sql
CREATE TABLE investments (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    account_id UUID,
    name VARCHAR(160) NOT NULL,
    amount NUMERIC(14,2) NOT NULL,
    expected_return NUMERIC(5,2),
    invested_at DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_investments_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);
```

---

# 🏦 LOANS

```sql
CREATE TABLE loans (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    account_id UUID,
    total_amount NUMERIC(14,2) NOT NULL,
    interest_rate NUMERIC(5,2),
    installments INTEGER,
    installment_value NUMERIC(14,2),
    start_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    updated_at TIMESTAMP NOT NULL DEFAULT now(),
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_loans_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);
```

---

# 🔔 NOTIFICATIONS

```sql
CREATE TABLE notifications (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    profile_id UUID NOT NULL,
    title VARCHAR(160),
    message TEXT,
    type VARCHAR(50),
    is_read BOOLEAN DEFAULT false,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    CONSTRAINT fk_notifications_profile
        FOREIGN KEY(profile_id)
        REFERENCES profiles(id)
        ON DELETE CASCADE
);
```

---

# 🐞 FEEDBACKS

```sql
CREATE TABLE feedbacks (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_id UUID NOT NULL,
    type VARCHAR(50),
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT now(),
    CONSTRAINT fk_feedback_user
        FOREIGN KEY(user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
```

