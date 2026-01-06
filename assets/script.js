document.addEventListener('DOMContentLoaded', () => {
    const QUESTION_TIME_LIMIT = 15; // seconds
    
    let questions = [];
    let currentQuestionIndex = 0;
    let results = [];
    let timerInterval;
    let timeRemaining;
    let questionStartTime;

    const dom = {
        timerBar: document.getElementById('timer-bar'),
        timerText: document.getElementById('timer-text'),
        questionCounter: document.getElementById('question-counter'),
        questionText: document.getElementById('question-text'),
        optionsContainer: document.getElementById('options-container'),
        nextBtn: document.getElementById('next-btn'),
        submissionForm: document.getElementById('submission-form'),
        resultsInput: document.getElementById('results_json')
    };

    async function initQuiz() {
        try {
            const { category, difficulty } = QUIZ_CONFIG;
            const response = await fetch(`api.php?category=${category}&difficulty=${difficulty}`);
            questions = await response.json();

            if (questions.length === 0) {
                dom.questionText.textContent = "No questions found for this selection.";
                return;
            }

            loadQuestion(0);
        } catch (error) {
            console.error("Failed to load questions:", error);
            dom.questionText.textContent = "Error loading quiz. Please try again.";
        }
    }

    function loadQuestion(index) {
        clearInterval(timerInterval);
        currentQuestionIndex = index;
        const question = questions[index];

        // UI Reset
        dom.questionText.textContent = question.question;
        dom.questionCounter.textContent = `Question ${index + 1}/${questions.length}`;
        dom.optionsContainer.innerHTML = '';
        dom.nextBtn.style.display = 'none'; // Hide next button until answered (optional, but requested automated flow usually implies immediate or timed transition)
        // Actually, per requirements: "One question at a time... navigation".
        // Let's allow manual Next for better UX, or auto on answer?
        // Requirement says: "Automatically submits when it hits zero".
        // Let's do: Pick answer -> Highlights -> Wait for Next OR timer runs out.

        question.options.forEach((opt, i) => {
            const btn = document.createElement('div');
            btn.className = 'option-btn';
            btn.innerHTML = `<span class="option-number">${i + 1}</span> ${opt}`;
            btn.onclick = () => selectOption(opt);
            dom.optionsContainer.appendChild(btn);
        });

        startTimer();
    }

    function startTimer() {
        timeRemaining = QUESTION_TIME_LIMIT;
        questionStartTime = Date.now();
        updateTimerUI();

        timerInterval = setInterval(() => {
            timeRemaining--;
            updateTimerUI();

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                handleTimeOut();
            }
        }, 1000);
    }

    function updateTimerUI() {
        dom.timerText.textContent = `${timeRemaining}s`;
        const percentage = (timeRemaining / QUESTION_TIME_LIMIT) * 100;
        dom.timerBar.style.width = `${percentage}%`;
        
        if (timeRemaining <= 5) {
            dom.timerBar.style.background = 'var(--danger-gradient)';
        } else {
            dom.timerBar.style.background = 'var(--secondary-gradient)';
        }
    }

    function selectOption(selectedOption) {
        clearInterval(timerInterval);
        const timeSpent = (Date.now() - questionStartTime) / 1000;
        const currentQ = questions[currentQuestionIndex];
        
        // Record result
        const isCorrect = selectedOption === currentQ.answer;
        results.push({
            questionId: currentQ.id,
            isCorrect: isCorrect,
            timeSpent: Math.min(timeSpent, QUESTION_TIME_LIMIT), // cap it
            selected: selectedOption,
            correctAnswer: currentQ.answer
        });

        // UI Feedback
        const buttons = dom.optionsContainer.children;
        for (let btn of buttons) {
            const btnText = btn.innerText.substring(2).trim(); // Remove number
            btn.onclick = null; // Disable clicks
            
            if (btnText === currentQ.answer) {
                btn.style.borderColor = 'var(--success-color)';
                btn.style.backgroundColor = 'rgba(16, 185, 129, 0.2)';
            } else if (btnText === selectedOption && !isCorrect) {
                btn.style.borderColor = '#ef4444';
                btn.style.backgroundColor = 'rgba(239, 68, 68, 0.2)';
            } else {
                btn.style.opacity = '0.5';
            }
        }

        // Show Next Button
        dom.nextBtn.style.display = 'inline-block';
        dom.nextBtn.onclick = goToNextQuestion;
    }

    function handleTimeOut() {
        // Treat as incorrect
        const currentQ = questions[currentQuestionIndex];
        results.push({
            questionId: currentQ.id,
            isCorrect: false,
            timeSpent: QUESTION_TIME_LIMIT,
            selected: null,
            correctAnswer: currentQ.answer
        });

        // Show correct answer
        const buttons = dom.optionsContainer.children;
        for (let btn of buttons) {
            const btnText = btn.innerText.substring(2).trim();
            btn.onclick = null;
            if (btnText === currentQ.answer) {
                btn.style.borderColor = 'var(--success-color)';
                btn.style.backgroundColor = 'rgba(16, 185, 129, 0.2)';
            } else {
                btn.style.opacity = '0.5';
            }
        }

        setTimeout(goToNextQuestion, 2000); // Auto advance after timeout
    }

    function goToNextQuestion() {
        if (currentQuestionIndex < questions.length - 1) {
            loadQuestion(currentQuestionIndex + 1);
        } else {
            finishQuiz();
        }
    }

    function finishQuiz() {
        dom.resultsInput.value = JSON.stringify(results);
        dom.submissionForm.submit();
    }

    initQuiz();
});
