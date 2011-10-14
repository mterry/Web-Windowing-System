<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="linkset">
		<xsl:apply-templates select="link" />
	</xsl:template>

	<xsl:template match="scriptset">
		<xsl:apply-templates select="script" />
	</xsl:template>

	<xsl:template match="link">
		<xsl:element name="link">
			<xsl:attribute name="rel">
				<xsl:value-of select="current()/rel" />
			</xsl:attribute>
			<xsl:attribute name="type">
				<xsl:value-of select="current()/type" />
			</xsl:attribute>
			<xsl:attribute name="href">
				<xsl:value-of select="$css" /><xsl:value-of select="current()/href" />
			</xsl:attribute>
		</xsl:element>
	</xsl:template>

	<xsl:template match="script">
		<xsl:element name="script">
			<xsl:attribute name="type">
				<xsl:value-of select="current()/type" />
			</xsl:attribute>
			<xsl:attribute name="src">
				<xsl:value-of select="$scripts" /><xsl:value-of select="current()/src" />
			</xsl:attribute>
		</xsl:element>
	</xsl:template>

	<xsl:template match="doc">
		<xsl:element name="html">
			<xsl:apply-templates select="head" />
			<xsl:apply-templates select="body" />
		</xsl:element>
	</xsl:template>

	<xsl:template match="head">
		<xsl:element name="head">
			<xsl:element name="title" />
			<xsl:apply-templates select="scriptset" />
			<xsl:apply-templates select="linkset" />
		</xsl:element>
	</xsl:template>

	<xsl:template match="body">
		<xsl:element name="body">
			<xsl:apply-templates select="*" />
		</xsl:element>
	</xsl:template>

	<xsl:template match="*">
		<xsl:element name="div">
			<xsl:attribute name="id">
				<xsl:value-of select="name()" />
			</xsl:attribute>
			<xsl:apply-templates select="*" />
		</xsl:element>
	</xsl:template>

	<xsl:output
		method="xml"
		version="1.0"
		encoding="utf-8"
		indent="yes"
		doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
		doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
	/>
</xsl:stylesheet>
