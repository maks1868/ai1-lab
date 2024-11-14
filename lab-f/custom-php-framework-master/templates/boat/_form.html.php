<div>
    <label for="name">Name:</label>
    <input type="text" id="name" name="boat[name]" value="<?= isset($boat) ? htmlspecialchars($boat->getName()) : '' ?>">
</div>
<div>
    <label for="length">Length (m):</label>
    <input type="number" id="length" name="boat[length]" step="0.01" value="<?= isset($boat) ? htmlspecialchars($boat->getLength()) : '' ?>">
</div>
<div>
    <label for="width">Width (m):</label>
    <input type="number" id="width" name="boat[width]" step="0.01" value="<?= isset($boat) ? htmlspecialchars($boat->getWidth()) : '' ?>">
</div>
<div>
    <label for="height">Height (m):</label>
    <input type="number" id="height" name="boat[height]" step="0.01" value="<?= isset($boat) ? htmlspecialchars($boat->getHeight()) : '' ?>">
</div>
<div>
    <label for="number_of_sails">Number of Sails:</label>
    <input type="number" id="number_of_sails" name="boat[number_of_sails]" value="<?= isset($boat) ? htmlspecialchars($boat->getNumberOfSails()) : '' ?>">
</div>
<button type="submit">Save</button>
