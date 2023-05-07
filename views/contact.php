<?php
    $this->title = 'Contact';
?>
<h1>Contact</h1>

<form action="" method="post">
    <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" name="subject" class="form-control" id="subject">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="email">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" name="message" id="message"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>