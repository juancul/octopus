/**
 * External dependencies
 */
import { dispatch } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

/**
 * Internal dependencies
 */
import { ADMIN_URL } from '../settings';

export const getWorkflowEditUrl = ( workflowId, origin = null ) => {
	return (
		`${ ADMIN_URL }post.php?post=${ workflowId }&action=edit` +
		( origin ? `&workflow-origin=${ origin }` : '' )
	);
};

export function handleFetchError( noticeText ) {
	const { createNotice } = dispatch( 'core/notices' );

	createNotice( 'error', noticeText );
}

/**
 * Get a single workflow.
 *
 * @param {number} workflowId
 * @return {Promise<boolean>} Fetch request promise.
 * @throws Error
 */
export async function getWorkflow( workflowId ) {
	const workflow = await apiFetch( {
		path: `/automatewoo/workflows/${ workflowId }`,
	} );

	if ( workflow ) {
		return workflow;
	}

	throw new Error();
}
