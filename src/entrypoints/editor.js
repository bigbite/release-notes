import { NAMESPACE } from '../editor/settings';
import DisplayComponent from '../editor/components/Display';

import '../editor/styles/styles.scss';

const { registerPlugin } = wp.plugins;

// Register the plugin.
wp.domReady(() => {
  registerPlugin(NAMESPACE, {
    icon: 'editor-paragraph',
    render: DisplayComponent,
  });
});
