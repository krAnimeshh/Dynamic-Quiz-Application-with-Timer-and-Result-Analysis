# Frugal Quiz

A dynamic, premium-designed quiz application built with PHP, HTML, CSS, and JavaScript.

## 🚀 Features
- **Dynamic Question Loading**: Fetches questions via a PHP API from a JSON data source.
- **Customizable Experience**: Select from multiple Categories (Science, History, Tech) and Difficulty levels.
- **Countdown Timer**: 15-second timer per question with visual progress bar.
- **Instant Feedback**: Immediate visual cues for correct/incorrect answers.
- **Detailed Result Analysis**: 
  - Score Calculation.
  - Interactive Charts (Time Spent per Question, Accuracy Breakdown).

## 🛠️ Tech Stack
- **Backend**: PHP (8.0+)
- **Frontend**: HTML5, CSS3 (Modern "Glassmorphism" Design), JavaScript (ES6+)
- **Data**: JSON
- **Libraries**: Chart.js (for result visualization)

## 📦 Setup & Installation

1. **Install PHP**: 
   Ensure PHP is installed on your system.
   *(We installed it via Winget: `winget install PHP.PHP.8.3`)*

2. **Clone/Download**:
   Place the project files in a folder on your computer.

3. **Start the Server**:
   You need to run a local PHP server to serve the API and files.

   **Option A: If PHP is in your System PATH**
   ```bash
   php -S localhost:8000
   ```

   **Option B: Using the Absolute Path (if 'php' command isn't found)**
   Run this in PowerShell inside the project folder:
   ```powershell
   & "C:\Users\HP\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" -S localhost:8000
   ```

4. **Play**:
   Open your browser and navigate to: [http://localhost:8000](http://localhost:8000)

## 📂 Project Structure
```
/
├── api.php             # Handles question filtering and serving
├── index.php           # Landing page (Category selection)
├── quiz.php            # Main quiz interface
├── result.php          # Results and charts
├── data/
│   └── questions.json  # Question database
└── assets/
    ├── style.css       # Premium modern styling
    └── script.js       # Core game logic
```
