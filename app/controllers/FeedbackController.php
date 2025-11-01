<?php

class FeedbackController
{
    private Feedback $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = new Feedback();
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $errors = $this->validateFeedback($_POST);

        if (empty($errors)) {
            $data = [
                'user_id' => Auth::getUserId(),
                'subject' => Validator::sanitize($_POST['subject']),
                'message' => Validator::sanitize($_POST['message']),
                'rating' => $_POST['rating'],
                'categories' => $_POST['categories'] ?? [],
                'contact_method' => $_POST['contact_method']
            ];

            if ($this->feedbackModel->create($data)) {
                header('Location: /feedback.php?success=1');
                exit;
            } else {
                $errors['general'] = 'Failed to submit feedback. Please try again.';
            }
        }

        return $this->showFeedbackForm($errors, $_POST);
    }

    private function validateFeedback(array $data): array
    {
        $errors = [];

        if (!Validator::validateRequired($data['subject'] ?? '')) {
            $errors['subject'] = 'Subject is required';
        }

        if (!Validator::validateRequired($data['message'] ?? '', 10)) {
            $errors['message'] = 'Message must be at least 10 characters long';
        }

        $allowedRatings = ['poor', 'average', 'good', 'excellent'];
        if (!Validator::validateInArray($data['rating'] ?? '', $allowedRatings)) {
            $errors['rating'] = 'Please select a valid rating';
        }

        $allowedCategories = ['service', 'quality', 'price', 'support'];
        if (isset($data['categories'])) {
            foreach ($data['categories'] as $category) {
                if (!Validator::validateInArray($category, $allowedCategories)) {
                    $errors['categories'] = 'Invalid category selected';
                    break;
                }
            }
        }

        $allowedMethods = ['email', 'phone', 'none'];
        if (!Validator::validateInArray($data['contact_method'] ?? '', $allowedMethods)) {
            $errors['contact_method'] = 'Please select a valid contact method';
        }

        return $errors;
    }

    public function showFeedbackForm(array $errors = [], array $data = []): void
    {
        $userFeedbacks = $this->feedbackModel->getAllByUser(Auth::getUserId());
        require __DIR__ . '/../../templates/feedback_form.php';
    }
}
