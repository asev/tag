    <tr>
        <td class="subject"><?php echo anchor('req/show/' . $requestId, $subject); ?></td>
        <td class="created"><?php echo anchor('req/show/' . $requestId, $created); ?></td>
        <td class="author"><?php echo anchor('req/show/' . $requestId, $fullName); ?></td>
        <td class="email"><?php echo anchor('req/show/' . $requestId, $email); ?></td>
        <td class="manager"><?php echo anchor('req/show/' . $requestId, $username); ?></td>
        <td class="status color<?php echo $state; ?>"></td>
    </tr>
