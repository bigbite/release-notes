const { PluginDocumentSettingPanel } = wp.editPost;
const {
  PanelRow,
  DatePicker,
  ToggleControl,
  SelectControl,
  __experimentalInputControl: InputControl,
  __experimentalNumberControl: NumberControl,
  __experimentalText: Text,
  __experimentalVStack: VStack,
  __experimentalHStack: HStack,
} = wp.components;
const { useEntityProp } = wp.coreData;
const { useSelect } = wp.data;
const { __ } = wp.i18n;

/** Adds the date selector to the post settings */
function CustomBlockFields() {
  const postType = useSelect((select) => select('core/editor').getCurrentPostType(), []);
  if (postType !== 'release-note') return null;

  const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
  const { version, is_pre_release: isPrerelease, release_date: releaseDate } = meta;

  const onDateChange = (val) => {
    setMeta({ ...meta, release_date: val });
  };

  return (
    <>
      <PluginDocumentSettingPanel initialOpen name="release-notes" title="Release Info">
        <PanelRow>
          {/** If the version is a string, it's a legacy version, so we show a single input */}
          {typeof version === 'string' ? (
            <InputControl
              value={version}
              onChange={(val) => setMeta({ ...meta, version: val })}
              label={__('Version Number')}
            />
          ) : (
            <HStack>
              <NumberControl
                shiftStep={1}
                min={0}
                value={version.major}
                onChange={(val) => setMeta({ ...meta, version: { ...version, major: val } })}
                spinControls="none"
              />
              <Text variant="label">.</Text>
              <NumberControl
                shiftStep={1}
                min={0}
                value={version.minor}
                onChange={(val) => setMeta({ ...meta, version: { ...version, minor: val } })}
                spinControls="none"
              />
              <Text variant="label">.</Text>
              <NumberControl
                shiftStep={1}
                min={0}
                value={version.patch}
                onChange={(val) => setMeta({ ...meta, version: { ...version, patch: val } })}
                spinControls="none"
              />
              <SelectControl
                className="release-notes__prerelease"
                value={version.prerelease}
                options={[
                  { label: 'None', value: '' },
                  { label: '-Alpha', value: '-alpha' },
                  { label: '-Beta', value: '-beta' },
                  { label: '-RC', value: '-rc' },
                ]}
                onChange={(val) => setMeta({ ...meta, version: { ...version, prerelease: val } })}
              />
              {version.prerelease && (
                <>
                  <Text variant="label">.</Text>
                  <NumberControl
                    shiftStep={1}
                    min={0}
                    value={version.prereleaseVersion}
                    onChange={(val) =>
                      setMeta({ ...meta, version: { ...version, prereleaseVersion: val } })
                    }
                    spinControls="none"
                  />
                </>
              )}
            </HStack>
          )}
        </PanelRow>
        <br />
        <PanelRow>
          <VStack>
            <Text variant="label">{__('Release Date')}</Text>
            <DatePicker
              currentDate={releaseDate}
              onChange={(val) => onDateChange(new Date(val).toISOString().split('T')[0])}
            />
          </VStack>
        </PanelRow>
        {typeof version === 'string' && (
          <>
            <br />
            <PanelRow>
              <ToggleControl
                label={__('Pre-Release Toggle')}
                checked={isPrerelease}
                onChange={(val) => setMeta({ ...meta, is_pre_release: val })}
              />
            </PanelRow>
          </>
        )}
      </PluginDocumentSettingPanel>
    </>
  );
}

export default CustomBlockFields;
