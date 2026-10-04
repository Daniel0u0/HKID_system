# HKID Validation & Generation System

A Python-based utility for validating, verifying, and generating Hong Kong Identity Card (HKID) numbers using the official check-digit algorithm.

---

## 📌 Overview

The **HKID System** provides tools to handle Hong Kong Identity Card (HKID) format checking and check-digit calculation. It helps developers ensure data integrity when capturing HKID information in applications, forms, or registration systems.

---

## ✨ Features

- **HKID Validation**: Validates whether a given HKID string follows the correct format and check-digit algorithm.
- **Check-Digit Calculation**: Automatically computes the correct check digit (0–9 or 'A') for single or double prefix letters.
- **Random HKID Generator**: Generates valid HKID numbers for testing, mock data creation, and unit tests.
- **Clean Interface**: Simple function calls that can easily be integrated into web backend systems or CLI applications.

---

## 🛠️ How HKID Validation Works

An HKID number consists of:
1. **Prefix**: 1 or 2 uppercase letters (e.g., `A` or `AB`).
2. **Digits**: 6 digits (e.g., `123456`).
3. **Check Digit**: 1 character inside parentheses, either a single digit `0–9` or the letter `A`.

The system applies official weight values to each character, computes a weighted sum modulo 11, and determines the valid check digit to verify authenticity.

---

## 🚀 Getting Started

### Prerequisites

- **Python 3.7+**

### Installation

1. Clone the repository:
   ```bash
   git clone [https://github.com/Daniel0u0/HKID_system.git](https://github.com/Daniel0u0/HKID_system.git)
   cd HKID_system
   ```

2. (Optional) Create and activate a virtual environment:
```bash
python -m venv venv
source venv/bin/activate  # On Windows use: venv\Scripts\activate

```



---

## 💻 Usage Example

```python
from hkid import validate_hkid, generate_hkid

# Validate an HKID
hkid_input = "A123456(3)"
is_valid = validate_hkid(hkid_input)
print(f"Is {hkid_input} valid? {is_valid}")

# Generate a random valid HKID for testing
mock_hkid = generate_hkid()
print(f"Generated HKID: {mock_hkid}")

```

---

## 📂 Project Structure

```text
HKID_system/
│
├── hkid.py            # Core logic for HKID validation and generation
├── tests/             # Unit tests for verification routines
├── README.md          # Project documentation
└── requirements.txt   # Dependencies (if any)

```

---

## ⚠️ Disclaimer

This project is intended **solely for educational, development, and software testing purposes**. The generated HKID numbers are algorithmically valid formatted strings meant for mock data testing and do **not** represent real individuals or officially issued government identities.

---

## 📄 License

This project is licensed under the [MIT License](https://www.google.com/search?q=LICENSE).

```
