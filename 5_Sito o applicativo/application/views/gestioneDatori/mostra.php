<h2>Mostra datore</h2>

<table class="table">
    <?php for($i = 0; $i < count($this->data) - 1; $i++) : ?>
        <tr>
            <?php for($j = 0; $j < count($this->data[$i]) - 1; $j++) : ?>
                <td><?php echo $this->data[$i][$this->template[$j]]; ?></td>
            <?php endfor; ?>
        <tr>
    <?php endfor; ?>
</table>