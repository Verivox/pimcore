/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.settings.targeting.condition.abstract");
/**
 * @private
 */
pimcore.settings.targeting.condition.abstract = Class.create({
    matchesScope: function (scope) {
        return 'targeting_rule' === scope;
    },

    getName: function () {
        console.error('Name is not set for condition', this);
    },

    getIconCls: function () {
        return 'pimcore_icon_add';
    },

    getPanel: function () {
        console.error('You have to implement the getPanel() method in condition', this);
    },

    isAvailable: function () {
        return true;
    }
});
