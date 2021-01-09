<?php

/**
 * Copyright (c) 2015-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */
namespace PYS_PRO_GLOBAL\FacebookAds\Object;

use PYS_PRO_GLOBAL\FacebookAds\ApiRequest;
use PYS_PRO_GLOBAL\FacebookAds\Cursor;
use PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface;
use PYS_PRO_GLOBAL\FacebookAds\TypeChecker;
use PYS_PRO_GLOBAL\FacebookAds\Object\Fields\LinkFields;
use PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentCommentPrivacyValueValues;
use PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentFilterValues;
use PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentLiveFilterValues;
use PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentOrderValues;
/**
 * This class is auto-generated.
 *
 * For any issues or feature requests related to this class, please let us know
 * on github and we'll fix in our codegen framework. We'll not be able to accept
 * pull request for this class.
 *
 */
class Link extends \PYS_PRO_GLOBAL\FacebookAds\Object\AbstractCrudObject
{
    /**
     * @return LinkFields
     */
    public static function getFieldsEnum()
    {
        return \PYS_PRO_GLOBAL\FacebookAds\Object\Fields\LinkFields::getInstance();
    }
    protected static function getReferencedEnums()
    {
        $ref_enums = array();
        return $ref_enums;
    }
    public function getComments(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('filter' => 'filter_enum', 'live_filter' => 'live_filter_enum', 'order' => 'order_enum', 'since' => 'datetime');
        $enums = array('filter_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentFilterValues::getInstance()->getValues(), 'live_filter_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentLiveFilterValues::getInstance()->getValues(), 'order_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentOrderValues::getInstance()->getValues());
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/comments', new \PYS_PRO_GLOBAL\FacebookAds\Object\Comment(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\Comment::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function createComment(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array('attachment_id' => 'string', 'attachment_share_url' => 'string', 'attachment_url' => 'string', 'comment_privacy_value' => 'comment_privacy_value_enum', 'facepile_mentioned_ids' => 'list<string>', 'feedback_source' => 'string', 'is_offline' => 'bool', 'message' => 'string', 'nectar_module' => 'string', 'object_id' => 'string', 'parent_comment_id' => 'Object', 'text' => 'string', 'tracking' => 'string');
        $enums = array('comment_privacy_value_enum' => \PYS_PRO_GLOBAL\FacebookAds\Object\Values\CommentCommentPrivacyValueValues::getInstance()->getValues());
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_POST, '/comments', new \PYS_PRO_GLOBAL\FacebookAds\Object\Comment(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\Comment::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getLikes(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/likes', new \PYS_PRO_GLOBAL\FacebookAds\Object\Profile(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\Profile::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getSharedPosts(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/sharedposts', new \PYS_PRO_GLOBAL\FacebookAds\Object\Post(), 'EDGE', \PYS_PRO_GLOBAL\FacebookAds\Object\Post::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
    public function getSelf(array $fields = array(), array $params = array(), $pending = \false)
    {
        $this->assureId();
        $param_types = array();
        $enums = array();
        $request = new \PYS_PRO_GLOBAL\FacebookAds\ApiRequest($this->api, $this->data['id'], \PYS_PRO_GLOBAL\FacebookAds\Http\RequestInterface::METHOD_GET, '/', new \PYS_PRO_GLOBAL\FacebookAds\Object\Link(), 'NODE', \PYS_PRO_GLOBAL\FacebookAds\Object\Link::getFieldsEnum()->getValues(), new \PYS_PRO_GLOBAL\FacebookAds\TypeChecker($param_types, $enums));
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}
