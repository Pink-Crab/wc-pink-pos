<?php

declare (strict_types=1);
/**
 * Used to regiter and unregister hooks.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @since 0.3.6
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Loader
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Loader;

use InvalidArgumentException;
use pc_pink_pos_0_0_1\PinkCrab\Loader\Hook;
use pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Removal;
use pc_pink_pos_0_0_1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception;
class Hook_Manager
{
    /**
     * Maps the hook types to the correct registration method.
     * @var array<string, string>
     */
    protected const TYPE_MAP = array(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook::ACTION => 'register_action', \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook::FILTER => 'register_filter', \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook::AJAX => 'register_ajax', \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook::SHORTCODE => 'register_shortcode', \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook::REMOVE => 'register_remove');
    /**
     * Callback used to process a hook
     *
     * @param Hook $hook
     * @return Hook
     */
    public function process_hook(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        if ($this->validate_context($hook) && \array_key_exists($hook->get_type(), self::TYPE_MAP)) {
            return $this->register_hook($hook);
        }
        return $hook;
    }
    /**
     * Validates if in admin only admin hooks are registtered and if on front, only front.
     *
     * @param Hook $hook
     * @return bool
     */
    protected function validate_context(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : bool
    {
        if ($hook->is_admin() === \true && $hook->is_front() === \true) {
            return \true;
        } elseif (\is_admin() === \true && $hook->is_admin() === \true) {
            return \true;
        } elseif (\is_admin() === \false && $hook->is_front() === \true) {
            return \true;
        }
        return \false;
    }
    protected function register_hook(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        // Pass to corret handler.
        $method = self::TYPE_MAP[$hook->get_type()];
        return $this->{$method}($hook);
    }
    /**
     * Registers action hook
     *
     * @param Hook $hook
     * @return Hook
     * @throws Invalid_Hook_Callback_Exception
     */
    protected function register_action(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        if (!\is_callable($hook->get_callback())) {
            throw \pc_pink_pos_0_0_1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::from_hook($hook);
        }
        add_action($hook->get_handle(), $hook->get_callback(), $hook->get_priority(), $hook->args_count());
        $hook->registered();
        return $hook;
    }
    /**
     * Registers a filter action
     *
     * @param Hook $hook
     * @return Hook
     * @throws Invalid_Hook_Callback_Exception
     */
    protected function register_filter(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        if (!\is_callable($hook->get_callback())) {
            throw \pc_pink_pos_0_0_1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::from_hook($hook);
        }
        add_filter($hook->get_handle(), $hook->get_callback(), $hook->get_priority(), $hook->args_count());
        $hook->registered();
        return $hook;
    }
    /**
     * Removes a hook using hook_removal
     *
     * @param Hook $hook
     * @return Hook
     */
    protected function register_remove(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        // Remove the hook.
        try {
            (new \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Removal($hook->get_handle(), $hook->get_callback(), $hook->get_priority()))->remove();
        } catch (\InvalidArgumentException $th) {
            throw \pc_pink_pos_0_0_1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::from_hook($hook);
        }
        $hook->registered();
        return $hook;
    }
    /**
     * Register a standard wp_ajax action
     *
     * @param Hook $hook
     * @return Hook
     * @throws Invalid_Hook_Callback_Exception
     */
    protected function register_ajax(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        if (!\is_callable($hook->get_callback())) {
            throw \pc_pink_pos_0_0_1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::from_hook($hook);
        }
        // Public Ajax
        if ($hook->is_ajax_public()) {
            add_action('wp_ajax_nopriv_' . $hook->get_handle(), $hook->get_callback());
        }
        // Private Ajax
        if ($hook->is_ajax_private()) {
            add_action('wp_ajax_' . $hook->get_handle(), $hook->get_callback());
        }
        $hook->registered();
        return $hook;
    }
    /**
     * Registers a wp shortcode.
     *
     * @param Hook $hook
     * @return Hook
     * @throws Invalid_Hook_Callback_Exception
     */
    protected function register_shortcode(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook $hook) : \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook
    {
        if (!\is_callable($hook->get_callback())) {
            throw \pc_pink_pos_0_0_1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::from_hook($hook);
        }
        \add_shortcode($hook->get_handle(), $hook->get_callback());
        $hook->registered();
        return $hook;
    }
}
