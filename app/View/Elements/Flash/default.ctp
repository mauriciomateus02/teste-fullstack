<?php
$toastClass = 'text-bg-primary';

if (!empty($params['class'])) {
    if (strpos($params['class'], 'success') !== false) $toastClass = 'text-bg-success';
    if (strpos($params['class'], 'error')   !== false) $toastClass = 'text-bg-danger';
    if (strpos($params['class'], 'warning') !== false) $toastClass = 'text-bg-warning';
}
?>
<div class="toast align-items-center <?php echo $toastClass; ?> border-0 show position-fixed bottom-0 end-0 m-3"
     role="alert" aria-live="assertive" aria-atomic="true" id="<?php echo $key; ?>Toast">
    <div class="d-flex">
        <div class="toast-body">
            <?php echo h($message); ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<script>
    var toastEl = document.getElementById('<?php echo $key; ?>Toast');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
</script>
