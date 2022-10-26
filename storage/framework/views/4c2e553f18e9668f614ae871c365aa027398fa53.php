<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppor Ticket Information</title>
</head>
<body>
    <p>
        Thank you <?php echo e(ucfirst($user->name)); ?> for contacting our support team. A support ticket has been opened for you. You will be notified when a response is made by email. The details of your ticket are shown below:
    </p>

    <p>Title: <?php echo e($ticket->title); ?></p>
    <p>Priority: <?php echo e($ticket->priority); ?></p>
    <p>Status: <?php echo e($ticket->status); ?></p>

    <p>
        You can view the ticket at any time at <?php echo e(url('tickets/'. $ticket->ticket_id)); ?>

    </p>

</body>
</html>